<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withImportNames(removeUnusedImports: true)
    ->withPreparedSets(typeDeclarations: true, codingStyle: true, naming: true, codeQuality: true)
    ->withSets([LevelSetList::UP_TO_PHP_81]);
