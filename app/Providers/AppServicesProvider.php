<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormRegistry;
use Symfony\Component\Form\ResolvedFormTypeFactory;
use Twig\Environment;

final class AppServicesProvider extends ServiceProvider
{
    public function register(): void
    {
        // add twig environment here
        $this->app->singleton(Environment::class, function () {
            return require_once __DIR__ . '/../../twig-environment-provider.php';
        });

        $this->app->singleton(FormFactoryInterface::class, function () {
            // @todo create with full context
            return new FormFactory(new FormRegistry([], new ResolvedFormTypeFactory()));
        });
    }

    public function boot(): void
    {
    }
}
