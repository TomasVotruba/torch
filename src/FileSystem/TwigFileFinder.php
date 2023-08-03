<?php

declare (strict_types=1);
namespace Torch202308\TomasVotruba\Torch\FileSystem;

use Torch202308\Symfony\Component\Finder\Finder;
use Torch202308\Webmozart\Assert\Assert;
final class TwigFileFinder
{
    /**
     * @param string[] $paths
     * @param string[] $excludedFiles
     * @return string[]
     */
    public function findInDirectories(array $paths, array $excludedFiles) : array
    {
        Assert::allString($paths);
        Assert::allString($excludedFiles);
        $files = [];
        $directories = [];
        foreach ($paths as $path) {
            if (\is_file($path)) {
                $files[] = $path;
            } else {
                $directories[] = $path;
            }
        }
        if ($directories !== []) {
            $finder = new Finder();
            $finder->name('*.twig')->files()->in($directories)->notName('#form_errors\\.html\\.twig#')->notPath('tooling');
            $fileInfos = \iterator_to_array($finder->getIterator());
            $directoryFiles = \array_keys($fileInfos);
            $files = \array_merge($files, $directoryFiles);
        }
        // remove excluded files
        return \array_filter($files, static function (string $file) use($excludedFiles) : bool {
            return !\in_array($file, $excludedFiles, \true);
        });
    }
}
