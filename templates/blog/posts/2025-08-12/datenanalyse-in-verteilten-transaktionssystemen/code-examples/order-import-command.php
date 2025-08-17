<?php

namespace App\Command;

use App\DataFrames\Orders;
use App\DataFrames\OrdersCSV;
use App\Dbal\SchemaProvider;
use Doctrine\DBAL\Connection;
use Flow\Doctrine\Bulk\Dialect\SqliteInsertOptions;
use Flow\ETL\Rows;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use function Flow\ETL\Adapter\Doctrine\from_dbal_key_set_qb;
use function Flow\ETL\Adapter\Doctrine\pagination_key_desc;
use function Flow\ETL\Adapter\Doctrine\pagination_key_set;
use function Flow\ETL\Adapter\Doctrine\to_dbal_table_insert;
use function Flow\ETL\DSL\analyze;
use function Flow\ETL\DSL\constraint_unique;
use function Flow\ETL\DSL\data_frame;
use function Flow\ETL\DSL\lit;
use function Flow\ETL\DSL\ref;
use function Flow\ETL\DSL\rename_replace;
use function Flow\ETL\DSL\schema_to_ascii;
use function Flow\Types\DSL\type_datetime;

#[AsCommand(
    name: 'app:orders:import',
    description: 'Import orders from the transactional database to the analytical database.',
)]
class OrdersImportCommand extends Command
{
    public function __construct(
        private readonly Connection $transactional,
        private readonly Connection $analytical,
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addOption('start-date', null, InputOption::VALUE_REQUIRED, 'Start date for the data pull.', '-24 hours')
            ->addOption('end-date', null, InputOption::VALUE_REQUIRED, 'End date for the data pull.', 'now')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Importing orders');

        $startDate = type_datetime()->cast($input->getOption('start-date'));
        $endDate = type_datetime()->cast($input->getOption('end-date'));

        $io->progressStart();

        $report = data_frame()
            ->read(
                from_dbal_key_set_qb(
                    $this->transactional,
                    $this->transactional->createQueryBuilder()
                        ->select('*')
                        ->from(SchemaProvider::ORDERS)
                        ->where('updated_at BETWEEN :start_date AND :end_date')
                        ->setParameter('start_date', $startDate->format('Y-m-d H:i:s'))
                        ->setParameter('end_date', $endDate->format('Y-m-d H:i:s')),
                    pagination_key_set(
                        pagination_key_desc('updated_at'),
                        pagination_key_desc('order_id')
                    )
                )->withSchema(Orders::sourceSchema())
            )
            ->withEntry('_address', ref('address')->unpack())
            ->renameEach(rename_replace('_address.', ''))
            ->withEntry('_item', ref('items')->expand())
            ->withEntry('_item', ref('_item')->unpack())
            ->renameEach(rename_replace('_item.', ''))
            ->drop('_item', 'items', 'address')
            ->withEntry('currency', lit('USD'))
            ->withEntry('price', ref('price')->multiply(100))
            ->constrain(constraint_unique('item_id'))
            ->match(Orders::destinationSchema())
            ->write(
                to_dbal_table_insert(
                    $this->analytical,
                    SchemaProvider::ORDER_LINE_ITEMS,
                    SqliteInsertOptions::fromArray([
                        'conflict_columns' => ['item_id'],
                    ])
                )
            )
            ->run(function (Rows $rows) use ($io) {
                $io->progressAdvance($rows->count());
            }, analyze: analyze())
        ;

        $io->progressFinish();

        $io->newLine();

        $io->definitionList(
            'Orders Import Summary',
            new TableSeparator(),
            ['Execution time ' => \number_format($report->statistics()->executionTime->highResolutionTime->seconds) . ' seconds'],
            ['Memory usage ' => \number_format($report->statistics()->memory->max()->inMb()) . ' MB'],
            ['Rows inserted ' => \number_format($report->statistics()->totalRows())],
        );

        return Command::SUCCESS;
    }
}
