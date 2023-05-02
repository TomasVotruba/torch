<?php

declare(strict_types=1);

return \TomasVotruba\PunchCard\AppConfig::make()
    ->providers([
        \TomasVotruba\Torch\Providers\AppServicesProvider::class,
    ])
    ->toArray();
