<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Container;

use Illuminate\Container\Container;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormRegistry;
use Symfony\Component\Form\ResolvedFormTypeFactory;
use TomasVotruba\Torch\Command\RunCommand;
use TomasVotruba\Torch\Contract\TwigEnvironmentDecoratorInterface;
use TomasVotruba\Torch\Reflection\PrivatesAccessor;
use TomasVotruba\Torch\Twig\TolerantTwigEnvironmentFactory;
use TomasVotruba\Torch\Twig\TolerantTwigFunctionFilterDecorator;
use Twig\Environment;

final class TorchContainerFactory
{
    public function create(): Container
    {
        $container = new Container();

        $container->singleton(RunCommand::class);

        // console
        $container->singleton(Application::class, function (Container $container) {
            $application = new Application('Torch', '1.0');

            $runCommand = $container->get(RunCommand::class);
            $application->add($runCommand);

            return $application;
        });

        $container->singleton(SymfonyStyle::class, function (): SymfonyStyle {
            return new SymfonyStyle(new ArrayInput([]), new ConsoleOutput());
        });

        // add twig environment here
        $container->singleton(Environment::class, static fn () => require __DIR__ . '/../../twig-environment-provider.php');

        $container->singleton(
            FormFactoryInterface::class,
            static fn (): FormFactory => // @todo create with full context of form registries :)
            new FormFactory(new FormRegistry([], new ResolvedFormTypeFactory()))
        );

        $container->singleton(
            TolerantTwigEnvironmentFactory::class,
            fn (): TolerantTwigEnvironmentFactory => new TolerantTwigEnvironmentFactory(
                $container->get(PrivatesAccessor::class),
                $container->get(Environment::class),
                $container->get(TolerantTwigFunctionFilterDecorator::class),
                $container->get(FormFactoryInterface::class),
                $container->tagged(TwigEnvironmentDecoratorInterface::class)
            )
        );

        // set default parameters - must be an array
        config([
            'parameters.functions_to_skip' => [],
        ]);

        return $container;
    }
}
