<?php

declare(strict_types=1);

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use TomasVotruba\Torch\DependencyInjection\TorchContainerFactory;

if (file_exists(__DIR__ . '/../../../../vendor/autoload.php')) {
    // A. dev repository
    require_once __DIR__ . '/../../../../vendor/autoload.php';
} else {
    // B. local repository
    require_once __DIR__ . '/../vendor/autoload.php';
}

$torchContainerFactory = new TorchContainerFactory();
$container = $torchContainerFactory->create();

/** @var Application $application */
$application = $container->make(Application::class);
$application->run(new ArgvInput(), new ConsoleOutput());
