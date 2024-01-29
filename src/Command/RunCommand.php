<?php

declare (strict_types=1);
namespace TomasVotruba\Torch\Command;

use Torch202401\Symfony\Component\Console\Command\Command;
use Torch202401\Symfony\Component\Console\Input\InputArgument;
use Torch202401\Symfony\Component\Console\Input\InputInterface;
use Torch202401\Symfony\Component\Console\Input\InputOption;
use Torch202401\Symfony\Component\Console\Output\OutputInterface;
use Torch202401\Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;
use TomasVotruba\Torch\FileSystem\FileSystem;
use TomasVotruba\Torch\FileSystem\TwigFileFinder;
use TomasVotruba\Torch\Twig\TolerantTwigEnvironmentFactory;
final class RunCommand extends Command
{
    /**
     * @readonly
     * @var \TomasVotruba\Torch\Twig\TolerantTwigEnvironmentFactory
     */
    private $tolerantTwigEnvironmentFactory;
    /**
     * @readonly
     * @var \TomasVotruba\Torch\FileSystem\TwigFileFinder
     */
    private $twigFileFinder;
    /**
     * @readonly
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @readonly
     * @var string
     */
    private $cacheDirectory;
    public function __construct(TolerantTwigEnvironmentFactory $tolerantTwigEnvironmentFactory, TwigFileFinder $twigFileFinder, SymfonyStyle $symfonyStyle)
    {
        $this->tolerantTwigEnvironmentFactory = $tolerantTwigEnvironmentFactory;
        $this->twigFileFinder = $twigFileFinder;
        $this->symfonyStyle = $symfonyStyle;
        $this->cacheDirectory = \sys_get_temp_dir() . '/torch_twig_cache';
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setName('run');
        $this->setDescription('Render twig templates to test their values out');
        $this->addArgument('paths', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Path to twig directories to smoke test');
        $this->addOption('exclude-file', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED);
    }
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $twigFiles = $this->findTwigFiles($input);
        $this->symfonyStyle->info(\sprintf('Found %d twig files', \count($twigFiles)));
        $tolerantTwigEnvironment = $this->tolerantTwigEnvironmentFactory->create($twigFiles);
        if ($this->symfonyStyle->isDebug()) {
            $this->symfonyStyle->progressStart(\count($twigFiles));
        }
        // clear cache, as the files do not override if tag parser changes
        FileSystem::deleteDirectory($this->cacheDirectory);
        $invalidFiles = [];
        foreach ($twigFiles as $twigFile) {
            if ($this->symfonyStyle->isDebug()) {
                $this->symfonyStyle->writeln($twigFile);
            } else {
                $this->symfonyStyle->progressAdvance();
            }
            try {
                $tolerantTwigEnvironment->render($twigFile);
            } catch (Throwable $throwable) {
                // in debug, throw exception directly to explore the stack trace
                if ($this->symfonyStyle->isDebug()) {
                    throw $throwable;
                }
                $invalidFiles[$twigFile] = $throwable->getMessage();
            }
        }
        if (!$this->symfonyStyle->isDebug()) {
            $this->symfonyStyle->progressFinish();
        }
        if ($invalidFiles === []) {
            $this->symfonyStyle->success('TWIG files are properly compiled');
            // success
            return self::SUCCESS;
        }
        $this->reportInvalidFiles($invalidFiles, $twigFiles);
        return self::FAILURE;
    }
    /**
     * @return string[]
     */
    private function findTwigFiles(InputInterface $input) : array
    {
        $paths = (array) $input->getArgument('paths');
        $excludedFiles = (array) $input->getOption('exclude-file');
        return $this->twigFileFinder->findInDirectories($paths, $excludedFiles);
    }
    /**
     * @param string[] $invalidFiles
     * @param string[] $files
     */
    private function reportInvalidFiles(array $invalidFiles, array $files) : void
    {
        $i = 1;
        foreach ($invalidFiles as $filePath => $fileError) {
            $fileTitle = \sprintf('%d) %s', $i, $filePath);
            $this->symfonyStyle->title($fileTitle);
            $this->symfonyStyle->writeln('    ' . $fileError);
            $this->symfonyStyle->newLine(2);
            ++$i;
        }
        $this->symfonyStyle->error(\sprintf('Failed to compile %d files out of %d', \count($invalidFiles), \count($files)));
    }
}
