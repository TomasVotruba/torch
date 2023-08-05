<?php

declare (strict_types=1);
namespace TomasVotruba\Torch\DependencyInjection;

use Torch202308\Illuminate\Container\Container;
use Torch202308\Symfony\Component\Console\Application;
use Torch202308\Symfony\Component\Console\Input\ArrayInput;
use Torch202308\Symfony\Component\Console\Output\ConsoleOutput;
use Torch202308\Symfony\Component\Console\Style\SymfonyStyle;
use TomasVotruba\Torch\Command\RunCommand;
use TomasVotruba\Torch\Config\StaticParameterProvider;
use TomasVotruba\Torch\Contract\TwigEnvironmentDecoratorInterface;
use TomasVotruba\Torch\Enum\ParameterName;
use TomasVotruba\Torch\Twig\TolerantTwigEnvironmentFactory;
use Twig\Environment;
use Torch202308\Webmozart\Assert\Assert;
/**
 * @api used in bin and tests
 */
final class TorchContainerFactory
{
    public function create() : Container
    {
        $container = new Container();
        // console
        $container->singleton(Application::class, static function (Container $container) : Application {
            $application = new Application('Torch', '1.0');
            $runCommand = $container->make(RunCommand::class);
            $application->add($runCommand);
            return $application;
        });
        $container->singleton(SymfonyStyle::class, static function () : SymfonyStyle {
            return new SymfonyStyle(new ArrayInput([]), new ConsoleOutput());
        });
        // add app's twig environment
        $container->singleton(Environment::class, function () : Environment {
            $torchConfigFilePath = \getcwd() . '/torch.php';
            Assert::fileExists($torchConfigFilePath);
            return require $torchConfigFilePath;
        });
        $container->singleton(TolerantTwigEnvironmentFactory::class);
        $container->when(TolerantTwigEnvironmentFactory::class)->needs('$twigEnvironmentDecorators')->giveTagged(TwigEnvironmentDecoratorInterface::class);
        // set default parameters - must be an array
        StaticParameterProvider::set(ParameterName::FUNCTIONS_TO_SKIP, []);
        return $container;
    }
}
