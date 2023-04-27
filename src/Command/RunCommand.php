<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Command;

use Illuminate\Console\Command;
use Nette\Utils\FileSystem;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;
use TomasVotruba\Torch\FileSystem\TwigFileFinder;
use TomasVotruba\Torch\Twig\TolerantTwigEnvironmentFactory;

final class RunCommand extends Command
{
    private string $cacheDirectory;

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
        private readonly TolerantTwigEnvironmentFactory $tolerantTwigFactory,
        private readonly TwigFileFinder $twigFileFinder,
    ) {
        $this->tolerantTwigFactory = $tolerantTwigFactory;
        $this->twigFileFinder = $twigFileFinder;
        $this->cacheDirectory = __DIR__ . '/../../../../var/cache/twig';

        parent::__construct();
    }

    protected function configure(): void
    {
        //$this->addArgument(
        //    'paths',
        //    InputArgument::IS_ARRAY | InputArgument::REQUIRED,
        //    'Directories to look for TWIG files'
        //);
        //
        //$this->addOption('exclude-file', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'Exclude weird files by file path');
    }

    protected function handle(): int
    {
        $symfonyStyle = new SymfonyStyle($this->input, $this->output);

        $twigFiles = $this->findTwigFiles();
        $symfonyStyle->note(sprintf('Found %d twig files', count($twigFiles)));

        $tolerantTwigEnvironment = $this->tolerantTwigFactory->create($twigFiles);

        $isDebug = $output->getVerbosity() >= OutputInterface::VERBOSITY_DEBUG;
        if ($isDebug === false) {
            $symfonyStyle->progressStart(count($twigFiles));
        }

        // clear cache, as the files do not override if tag parser changes
        FileSystem::delete($this->cacheDirectory);

        $invalidFiles = [];

        foreach ($twigFiles as $twigFile) {
            if ($isDebug) {
                $symfonyStyle->writeln($twigFile);
            } else {
                $symfonyStyle->progressAdvance();
            }

            try {
                $tolerantTwigEnvironment->render($twigFile);
            } catch (Throwable $throwable) {
                // in debug, throw exception directly to explore the stack trace
                if ($isDebug) {
                    throw $throwable;
                }
                $invalidFiles[$twigFile] = $throwable->getMessage();
            }
        }

        if ($isDebug === false) {
            $symfonyStyle->progressFinish();
        }

        if ($invalidFiles === []) {
            $symfonyStyle->success('TWIG files are properly compiled');

            // success
            return StatusCode::SUCCESS;
        }

        $this->reportInvalidFiles($symfonyStyle, $invalidFiles, $twigFiles);

        return StatusCode::FAILURE;
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
