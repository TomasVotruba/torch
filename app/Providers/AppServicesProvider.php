<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormRegistry;
use Symfony\Component\Form\ResolvedFormTypeFactory;
use TomasVotruba\Torch\Enum\ServiceTag;
use TomasVotruba\Torch\Reflection\PrivatesAccessor;
use TomasVotruba\Torch\Twig\TolerantTwigEnvironmentFactory;
use TomasVotruba\Torch\Twig\TolerantTwigFunctionFilterDecorator;
use Twig\Environment;

final class AppServicesProvider extends ServiceProvider
{
    public function register(): void
    {
        // add twig environment here
        $this->app->singleton(Environment::class, function () {
            return require __DIR__ . '/../../twig-environment-provider.php';
        });

        $this->app->singleton(FormFactoryInterface::class, function () {
            // @todo create with full context of form registries :)
            return new FormFactory(new FormRegistry([], new ResolvedFormTypeFactory()));
        });

        $this->app->singleton(TolerantTwigEnvironmentFactory::class, function () {
            return new TolerantTwigEnvironmentFactory(
                // @todo can this be done in a simpler way?
                $this->app->make(PrivatesAccessor::class),
                $this->app->make(Environment::class),
                $this->app->make(TolerantTwigFunctionFilterDecorator::class),
                $this->app->make(FormFactoryInterface::class),
                $this->app->tagged(ServiceTag::TWIG_ENVIRONMENT_DECORATOR)
            );
        });
    }

    public function boot(): void
    {
    }
}
