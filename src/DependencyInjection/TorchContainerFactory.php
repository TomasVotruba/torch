<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\DependencyInjection;

use Illuminate\Container\Container;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomasVotruba\Torch\Command\RunCommand;
use TomasVotruba\Torch\Config\StaticParameterProvider;
use TomasVotruba\Torch\Contract\TwigEnvironmentDecoratorInterface;
use TomasVotruba\Torch\Enum\ParameterName;
use TomasVotruba\Torch\Helpers\PrivatesAccessor;
use TomasVotruba\Torch\Twig\TolerantTwigEnvironmentFactory;
use Twig\Environment;
use Webmozart\Assert\Assert;

/**
 * @api used in bin and tests
 */
final class TorchContainerFactory
{
    public function create(): Container
    {
        $container = new Container();

        // console
        $container->singleton(Application::class, static function (Container $container): Application {
            $application = new Application('Torch', '1.0');
            $runCommand = $container->make(RunCommand::class);
            $application->add($runCommand);

            // keep only relevant commands
            PrivatesAccessor::propertyClosure($application, 'commands', function (array $commands) {
                unset($commands['help']);
                unset($commands['completion']);
                return $commands;
            });

            return $application;
        });

        $container->singleton(SymfonyStyle::class, static fn (): SymfonyStyle => new SymfonyStyle(new ArrayInput([]), new ConsoleOutput()));

        // add app's twig environment
        $container->singleton(Environment::class, function (): Environment {
            $torchConfigFilePath = getcwd() . '/torch.php';
            Assert::fileExists($torchConfigFilePath);

            return require $torchConfigFilePath;
        });

        $container->singleton(TolerantTwigEnvironmentFactory::class);
        $container->when(TolerantTwigEnvironmentFactory::class)
            ->needs('$twigEnvironmentDecorators')
            ->giveTagged(TwigEnvironmentDecoratorInterface::class);

        // set default parameters - must be an array
        StaticParameterProvider::set(ParameterName::FUNCTIONS_TO_SKIP, []);

        return $container;
    }
}
