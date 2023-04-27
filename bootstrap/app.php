<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Exceptions\Handler;

$application = new Application( $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__));

// basic bindings
$application->singleton(Illuminate\Contracts\Console\Kernel::class, \Illuminate\Foundation\Console\Kernel::class);
$application->singleton(ExceptionHandler::class, Handler::class);

return $application;
