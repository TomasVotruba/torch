<?php

declare (strict_types=1);
namespace Torch202308;

use Torch202308\Symfony\Component\Console\Application;
use Torch202308\Symfony\Component\Console\Input\ArgvInput;
use Torch202308\Symfony\Component\Console\Output\ConsoleOutput;
use TomasVotruba\Torch\DependencyInjection\TorchContainerFactory;
if (\file_exists(__DIR__ . '/../../../../vendor/autoload.php')) {
    // project's autoload
    require_once __DIR__ . '/../../../../vendor/autoload.php';
}
if (\file_exists(__DIR__ . '/../vendor/scoper-autoload.php')) {
    // A. build downgraded package
    require_once __DIR__ . '/../vendor/scoper-autoload.php';
} else {
    // B. local repository
    require_once __DIR__ . '/../vendor/autoload.php';
}
$torchContainerFactory = new TorchContainerFactory();
$container = $torchContainerFactory->create();
/** @var Application $application */
$application = $container->make(Application::class);
$application->run(new ArgvInput(), new ConsoleOutput());
