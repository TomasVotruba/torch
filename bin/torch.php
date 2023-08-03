<?php

declare (strict_types=1);
namespace Torch202308;

use Torch202308\Symfony\Component\Console\Application;
use Torch202308\Symfony\Component\Console\Input\ArgvInput;
use Torch202308\Symfony\Component\Console\Output\ConsoleOutput;
use Torch202308\TomasVotruba\Torch\DependencyInjection\TorchContainerFactory;
require __DIR__ . '/../vendor/autoload.php';
$torchContainerFactory = new TorchContainerFactory();
$container = $torchContainerFactory->create();
/** @var Application $application */
$application = $container->make(Application::class);
$application->run(new ArgvInput(), new ConsoleOutput());
