<?php

declare(strict_types=1);

// see https://github.com/humbug/php-scoper
return [
    'prefix' => 'Torch' . date('Ym'),
    'expose-constants' => ['#^SYMFONY\_[\p{L}_]+$#'],
    'exclude-namespaces' => ['#^TomasVotruba\\\\ClassLeak#'],
];
