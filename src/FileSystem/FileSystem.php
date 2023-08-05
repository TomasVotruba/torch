<?php

namespace TomasVotruba\Torch\FileSystem;

use FilesystemIterator;
use Torch202308\Webmozart\Assert\Assert;
final class FileSystem
{
    public static function read(string $filePath) : string
    {
        $fileContents = \file_get_contents($filePath);
        Assert::string($fileContents);
        return $fileContents;
    }
    public static function deleteDirectory(string $directoryPath) : void
    {
        foreach (new FilesystemIterator($directoryPath) as $filePath) {
            \unlink($filePath);
        }
    }
}
