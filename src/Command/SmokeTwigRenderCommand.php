<?php

declare(strict_types=1);

namespace SmokedTwigRenderer\Command;

use AppBundle\Enum\StatusCode;
use Nette\Utils\FileSystem;
use SmokedTwigRenderer\FileSystem\TwigFileFinder;
use SmokedTwigRenderer\Twig\TolerantTwigEnvironmentFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

/**
 * Run like this:
 * SYMFONY_ENV=ci php app/console smoke-twig-render app
 */
final class SmokeTwigRenderCommand extends Command
{
    private TolerantTwigEnvironmentFactory $tolerantTwigFactory;

    private TwigFileFinder $twigFileFinder;

    private string $cacheDirectory;

    public function __construct(
        TolerantTwigEnvironmentFactory $tolerantTwigFactory,
        TwigFileFinder $twigFileFinder
    ) {
        $this->tolerantTwigFactory = $tolerantTwigFactory;
        $this->twigFileFinder = $twigFileFinder;
        $this->cacheDirectory = __DIR__ . '/../../../../var/cache/twig';

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('smoke-twig-render');

        $this->setDescription('Render twig templates to test their values out');
        $this->addArgument(
            'paths',
            InputArgument::IS_ARRAY | InputArgument::REQUIRED,
            'Directories to look for TWIG files'
        );

        $this->addOption('exclude-file', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED, 'Exclude weird files by file path');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyStyle = new SymfonyStyle($input, $output);

        $twigFiles = $this->findTwigFiles($input);
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
    private function findTwigFiles(InputInterface $input): array
    {
        $paths = (array) $input->getArgument('paths');
        $excludedFiles = (array) $input->getOption('exclude-file');

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
