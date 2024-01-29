<?php

declare(strict_types=1);

// this file that returns twig environment of the project
// here its for testing purposes only
use Symfony\Bridge\Twig\Extension\FormExtension;
use TomasVotruba\Torch\Config\StaticParameterProvider;
use TomasVotruba\Torch\ValueObject\DummyTheme;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

// only for demo purposes
// provide container and fetch environment service from it in your project instead
$environment = new Environment(
    new ArrayLoader([])
);

$environment->addExtension(new FormExtension());

// override twig functions you need
StaticParameterProvider::set('overrideFunctions', [
    // provide static value for dynamic function
    'baseTemplate' => function () {
        return DummyTheme::LAYOUT_NAME;
    },
]);

return $environment;
