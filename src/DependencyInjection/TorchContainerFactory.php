<?php

declare (strict_types=1);
namespace Torch202308\TomasVotruba\Torch\DependencyInjection;

use Torch202308\Illuminate\Container\Container;
use Torch202308\Symfony\Component\Console\Application;
use Torch202308\Symfony\Component\Console\Input\ArrayInput;
use Torch202308\Symfony\Component\Console\Output\ConsoleOutput;
use Torch202308\Symfony\Component\Console\Style\SymfonyStyle;
use Torch202308\Symfony\Component\Form\FormFactory;
use Torch202308\Symfony\Component\Form\FormFactoryInterface;
use Torch202308\Symfony\Component\Form\FormRegistry;
use Torch202308\Symfony\Component\Form\ResolvedFormTypeFactory;
use Torch202308\TomasVotruba\Torch\Command\RunCommand;
use Torch202308\TomasVotruba\Torch\Config\StaticParameterProvider;
use Torch202308\TomasVotruba\Torch\Contract\TwigEnvironmentDecoratorInterface;
use Torch202308\TomasVotruba\Torch\Reflection\PrivatesAccessor;
use Torch202308\TomasVotruba\Torch\Twig\TolerantTwigEnvironmentFactory;
use Torch202308\TomasVotruba\Torch\Twig\TolerantTwigFunctionFilterDecorator;
use Torch202308\Twig\Environment;
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
        // add twig environment here
        $container->singleton(Environment::class, static function () {
            return require __DIR__ . '/../../twig-environment-provider.php';
        });
        $container->singleton(FormFactoryInterface::class, static function () : FormFactory {
            return new FormFactory(new FormRegistry([], new ResolvedFormTypeFactory()));
        });
        $container->singleton(TolerantTwigEnvironmentFactory::class, static function () use($container) : TolerantTwigEnvironmentFactory {
            return new TolerantTwigEnvironmentFactory($container->get(PrivatesAccessor::class), $container->get(Environment::class), $container->get(TolerantTwigFunctionFilterDecorator::class), $container->get(FormFactoryInterface::class), $container->tagged(TwigEnvironmentDecoratorInterface::class));
        });
        // set default parameters - must be an array
        StaticParameterProvider::set('parameters.functions_to_skip', []);
        return $container;
    }
}
