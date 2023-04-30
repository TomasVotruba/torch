<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Command;

use Illuminate\Console\Command;
use Nette\Utils\FileSystem;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;
use TomasVotruba\Torch\FileSystem\TwigFileFinder;
use TomasVotruba\Torch\Twig\TolerantTwigEnvironmentFactory;

final class RunCommand extends Command
{
    private readonly string $cacheDirectory;

    /**
     * @var string
     * @see https://laravel.com/docs/10.x/artisan#defining-input-expectations
     */
    protected $signature = 'run {paths} {--exclude-file:*}';

    /**
     * @var string
     */
    protected $description = 'Render twig templates to test their values out';

    public function __construct(
        private readonly TolerantTwigEnvironmentFactory $tolerantTwigEnvironmentFactory,
        private readonly TwigFileFinder $twigFileFinder,
    ) {
        $this->cacheDirectory = __DIR__ . '/../../../../var/cache/twig';

        parent::__construct();
    }

    protected function handle(): int
    {
        $symfonyStyle = new SymfonyStyle($this->input, $this->output);

        $twigFiles = $this->findTwigFiles();
        $this->info(sprintf('Found %d twig files', count($twigFiles)));

        $tolerantTwigEnvironment = $this->tolerantTwigEnvironmentFactory->create($twigFiles);

        if ($this->output->isDebug()) {
            $symfonyStyle->progressStart(count($twigFiles));
        }

        // clear cache, as the files do not override if tag parser changes
        FileSystem::delete($this->cacheDirectory);

        $invalidFiles = [];

        foreach ($twigFiles as $twigFile) {
            if ($this->output->isDebug()) {
                $symfonyStyle->writeln($twigFile);
            } else {
                $symfonyStyle->progressAdvance();
            }

            try {
                $tolerantTwigEnvironment->render($twigFile);
            } catch (Throwable $throwable) {
                // in debug, throw exception directly to explore the stack trace
                if ($this->output->isDebug()) {
                    throw $throwable;
                }

                $invalidFiles[$twigFile] = $throwable->getMessage();
            }
        }

        if (! $this->output->isDebug()) {
            $symfonyStyle->progressFinish();
        }

        if ($invalidFiles === []) {
            $symfonyStyle->success('TWIG files are properly compiled');

            // success
            return self::SUCCESS;
        }

        $this->reportInvalidFiles($symfonyStyle, $invalidFiles, $twigFiles);

        return self::FAILURE;
    }

    /**
     * @return string[]
     */
    private function findTwigFiles(): array
    {
        $paths = (array) $this->argument('paths');
        $excludedFiles = (array) $this->option('exclude-file');

        return $this->twigFileFinder->findInDirectories($paths, $excludedFiles);
    }

    /**
     * @param string[] $invalidFiles
     * @param string[] $files
     */
    private function reportInvalidFiles(SymfonyStyle $symfonyStyle, array $invalidFiles, array $files): void
    {
        $i = 1;
        foreach ($invalidFiles as $filePath => $fileError) {
            $fileTitle = sprintf('%d) %s', $i, $filePath);
            $symfonyStyle->title($fileTitle);
            $symfonyStyle->writeln('    ' . $fileError);
            $symfonyStyle->newLine(2);

            ++$i;
        }

        $errorMessage = sprintf(
            'Failed to compile %d files out of %d',
            count($invalidFiles),
            count($files),
        );

        $symfonyStyle->error($errorMessage);
    }
}
