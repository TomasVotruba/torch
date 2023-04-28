<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\FileSystem;

use Symfony\Component\Finder\Finder;
use Webmozart\Assert\Assert;

final class TwigFileFinder
{
    /**
     * @param string[] $paths
     * @param string[] $excludedFiles
     * @return string[]
     */
    public function findInDirectories(array $paths, array $excludedFiles): array
    {
        Assert::allString($paths);
        Assert::allString($excludedFiles);

        $files = [];
        $directories = [];

        foreach ($paths as $path) {
            if (is_file($path)) {
                $files[] = $path;
            } else {
                $directories[] = $path;
            }
        }

        if ($directories) {
            $finder = new Finder();
            $finder->name('*.twig')
                ->files()
                ->in($directories)
                ->notName('#form_errors\.html\.twig#')
                ->notPath('tooling');

            $fileInfos = iterator_to_array($finder->getIterator());
            $directoryFiles = array_keys($fileInfos);

            $files = [...$files, ...$directoryFiles];
        }

        // remove excluded files
        return array_filter($files, fn (string $file) => ! in_array($file, $excludedFiles, true));
    }
}
