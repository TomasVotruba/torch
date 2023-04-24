<?php

declare(strict_types=1);

use SmokedTwigRenderer\Enum\ParameterName;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(ParameterName::FUNCTIONS_TO_SKIP, []);

    $services = $containerConfigurator->services();
    $services->defaults()
        ->public()
        ->autowire()
        ->autoconfigure();

    $services->load('SmokedTwigRenderer\\', __DIR__ . '/../src')
        ->exclude(__DIR__ . '/../src/ValueObject');

    // import root config if available
    $rootConfigFilePath = getcwd() . '/smoke-twig-renderer.php';
    if (file_exists($rootConfigFilePath)) {
        $containerConfigurator->import($rootConfigFilePath);
    }
};
