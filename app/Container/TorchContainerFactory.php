<?php

namespace TomasVotruba\Torch\Container;

use Illuminate\Container\Container;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormRegistry;
use Symfony\Component\Form\ResolvedFormTypeFactory;
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

        // add twig environment here
        $container->singleton(Environment::class, static fn () => require __DIR__ . '/../../twig-environment-provider.php');

        $container->singleton(
            FormFactoryInterface::class,
            static fn (): \Symfony\Component\Form\FormFactory => // @todo create with full context of form registries :)
            new FormFactory(new FormRegistry([], new ResolvedFormTypeFactory()))
        );

        $container->singleton(TolerantTwigEnvironmentFactory::class, fn (): TolerantTwigEnvironmentFactory => new TolerantTwigEnvironmentFactory(
        // @todo can this be done in a simpler way?
            $container->make(PrivatesAccessor::class),
            $container->make(Environment::class),
            $container->make(TolerantTwigFunctionFilterDecorator::class),
            $container->make(FormFactoryInterface::class),
            $container->tagged(TwigEnvironmentDecoratorInterface::class)
        ));

        return $container;
    }
}
