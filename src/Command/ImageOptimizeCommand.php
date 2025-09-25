<?php

declare(strict_types=1);

namespace NorbertTech\Portfolio\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

#[AsCommand(name: 'img:optimize', description: 'Optimize an image for web using ffmpeg')]
class ImageOptimizeCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'Path to the image file to optimize')
            ->addOption(
                'quality',
                null,
                InputOption::VALUE_REQUIRED,
                'Quality for JPEG (1-31, lower is better) or compression for PNG (0-9)',
                null,
            )
            ->addOption('width', 'w', InputOption::VALUE_REQUIRED, 'Max width (maintains aspect ratio)', null)
            ->addOption('format', 'f', InputOption::VALUE_REQUIRED, 'Output format (jpg, png, webp)', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $imagePath = $input->getArgument('path');

        if (!file_exists($imagePath)) {
            $io->error(sprintf('File not found: %s', $imagePath));
            return Command::FAILURE;
        }

        if (!is_file($imagePath)) {
            $io->error(sprintf('Path is not a file: %s', $imagePath));
            return Command::FAILURE;
        }

        $pathInfo = pathinfo($imagePath);
        $extension = strtolower($pathInfo['extension'] ?? '');

        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
            $io->error(sprintf('Unsupported file format: %s. Supported formats: jpg, jpeg, png, webp', $extension));
            return Command::FAILURE;
        }

        $checkProcess = new Process(['ffmpeg', '-version']);
        $checkProcess->run();

        if (!$checkProcess->isSuccessful()) {
            $io->error('ffmpeg is not installed or not available in PATH');
            return Command::FAILURE;
        }

        $io->info(sprintf('Optimizing image: %s', $imagePath));

        $originalSize = filesize($imagePath);
        $io->info(sprintf('Original size: %s', $this->formatBytes($originalSize)));

        $outputFormat = $input->getOption('format') ?: $extension;
        if ($outputFormat === 'jpeg') {
            $outputFormat = 'jpg';
        }

        $tempFile = $imagePath . '.tmp.' . $outputFormat;
        $command = $this->buildFfmpegCommand(
            $imagePath,
            $tempFile,
            $outputFormat,
            $input->getOption('quality'),
            $input->getOption('width'),
        );

        $io->note(sprintf('Running: %s', implode(' ', $command)));

        $process = new Process($command);
        $process->setTimeout(60);
        $process->run();

        if (!$process->isSuccessful()) {
            $io->error(sprintf("Failed to optimize image:\n%s", $process->getErrorOutput()));
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
            return Command::FAILURE;
        }

        if ($outputFormat !== $extension) {
            $newPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.' . $outputFormat;
            rename($tempFile, $newPath);
            unlink($imagePath); // Remove original with different extension
            $io->success(sprintf('Image optimized and converted to %s: %s', strtoupper($outputFormat), $newPath));
            $newSize = filesize($newPath);
        } else {
            rename($tempFile, $imagePath);
            $io->success(sprintf('Image optimized: %s', $imagePath));
            $newSize = filesize($imagePath);
        }

        $io->info(sprintf('New size: %s', $this->formatBytes($newSize)));
        $savedBytes = $originalSize - $newSize;
        $savedPercent = ($savedBytes / $originalSize) * 100;

        if ($savedBytes > 0) {
            $io->info(sprintf('Saved: %s (%.1f%%)', $this->formatBytes($savedBytes), $savedPercent));
        } else {
            $io->warning(sprintf('File size increased by %s', $this->formatBytes(abs($savedBytes))));
        }

        return Command::SUCCESS;
    }

    private function buildFfmpegCommand(
        string $inputPath,
        string $outputPath,
        string $outputFormat,
        null|string $quality,
        null|string $width,
    ): array {
        $command = ['ffmpeg', '-i', $inputPath, '-y'];

        if ($width !== null) {
            $command[] = '-vf';
            $command[] = sprintf('scale=%d:-1', (int) $width);
        }

        switch ($outputFormat) {
            case 'jpg':
            case 'jpeg':
                // JPEG quality: 2-31 (lower is better)
                $q = $quality !== null ? ((int) $quality) : 20;
                $command[] = '-q:v';
                $command[] = (string) $q;
                break;

            case 'png':
                // PNG compression: 0-100 (0 is lossless)
                $compression = $quality !== null ? ((int) $quality) : 100;
                $command[] = '-compression_level';
                $command[] = (string) $compression;
                $command[] = '-pred';
                $command[] = 'mixed';
                break;

            case 'webp':
                // WebP quality: 0-100 (higher is better)
                $q = $quality !== null ? ((int) $quality) : 85;
                $command[] = '-quality';
                $command[] = (string) $q;
                $command[] = '-compression_level';
                $command[] = '6';
                break;
        }

        $command[] = '-map_metadata';
        $command[] = '-1';

        // Output file
        $command[] = $outputPath;

        return $command;
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= 1 << (10 * $pow);

        return sprintf('%.2f %s', $bytes, $units[$pow]);
    }
}
