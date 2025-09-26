<?php

declare(strict_types=1);

namespace App\Dbal;

// use statements

final class SchemaProvider implements MigrationsSchemaProvider
{
    public const ANALYTICAL_ORDER_LINE_ITEMS = 'order_line_items';

    public function createSchema(): Schema
    {
        return new Schema(
            tables: [
                to_dbal_schema_table(Orders::destinationSchema(), self::ANALYTICAL_ORDER_LINE_ITEMS),
            ]
        );
    }
}