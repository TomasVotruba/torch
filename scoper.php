<?php

declare(strict_types=1);

// see https://github.com/humbug/php-scoper
return [
    'prefix' => 'Torch' . date('Ym'),
    'expose-constants' => ['#^SYMFONY\_[\p{L}_]+$#'],
    // https://github.com/humbug/php-scoper/blob/main/docs/configuration.md#exposing-classes
    'exclude-namespaces' => ['#^TomasVotruba\\\\Torch#'],
    'exclude-classes' => [
        'Twig\Environment',
        'PHPUnit\Framework\TestCase',
    ],
];
