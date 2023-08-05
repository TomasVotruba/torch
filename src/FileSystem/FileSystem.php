<?php

namespace TomasVotruba\Torch\FileSystem;

use FilesystemIterator;
use TomasVotruba\Torch\Exception\ShouldNotHappenException;
final class FileSystem
{
    public static function read(string $filePath) : string
    {
        $fileContents = \file_get_contents($filePath);
        if ($fileContents === \false) {
            throw new ShouldNotHappenException(\sprintf('Unable to read "%s" filePath', $filePath));
        }
        return $fileContents;
    }
    public static function deleteDirectory(string $directoryPath) : void
    {
        foreach (new FilesystemIterator($directoryPath) as $filePath) {
            \unlink($filePath);
        }
    }
}
