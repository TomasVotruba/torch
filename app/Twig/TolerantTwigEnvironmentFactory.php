<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Twig;

use Nette\Utils\FileSystem;
use Symfony\Component\Form\FormFactoryInterface;
use TomasVotruba\Torch\Reflection\PrivatesAccessor;
use TomasVotruba\Torch\ValueObject\DummyTheme;
use Twig\Environment;
use Twig\Extension\StagingExtension;
use Twig\Loader\ArrayLoader;
use Twig\Loader\ChainLoader;

/**
 * @see \TomasVotruba\Torch\Tests\Twig\TolerantTwigEnvironmentTest
 */
final class TolerantTwigEnvironmentFactory
{
    public function __construct(
        private readonly PrivatesAccessor $privatesAccessor,
        private readonly Environment $environment,
        private readonly TolerantTwigFunctionFilterDecorator $tolerantTwigFunctionFilterDecorator,
        private readonly FormFactoryInterface $formFactory
    ) {
    }

    /**
     * @param string[] $twigFiles
     */
    public function create(array $twigFiles): TolerantTwigEnvironment
    {
        $environment = $this->environment;
        $isolatedEnvironment = clone $environment;

        $this->decorateLoaderWithFiles($isolatedEnvironment, $twigFiles);

        // add tolerant functions and filters
        $this->decorateTolerantFiltersAndFunctions($isolatedEnvironment);

        // required to have tolerant twig, that have no variables
        $isolatedEnvironment->disableStrictVariables();

        return new TolerantTwigEnvironment($isolatedEnvironment, $this->formFactory);
    }

    /**
     * @param string[] $twigFiles
     */
    private function decorateLoaderWithFiles(Environment $environment, array $twigFiles): void
    {
        $originalLoader = $environment->getLoader();
        $arrayLoader = new ArrayLoader();
        $chainLoader = new ChainLoader([$arrayLoader, $originalLoader]);

        // prepare loader with files so it can easily render
        foreach ($twigFiles as $name => $twigFile) {
            $twigFileContents = FileSystem::read($twigFile);

            if (is_string($name)) {
                $arrayLoader->setTemplate($name, $twigFileContents);
            } else {
                $arrayLoader->setTemplate($twigFile, $twigFileContents);
            }
        }

        // dummy templates to re-use instead of dynamic ones
        $defaultLayoutContents = FileSystem::read(__DIR__ . '/../../templates/dummy_layout.twig');
        $arrayLoader->setTemplate(DummyTheme::LAYOUT_NAME, $defaultLayoutContents);

        $environment->setLoader($chainLoader);
    }

    /**
     * @see https://gist.github.com/TomasVotruba/b3520601c474fbea0488cc74c08e18fb
     */
    private function decorateTolerantFiltersAndFunctions(Environment $environment): void
    {
        // after we fetch these, the staging must be reset to the twig environment is not locked
        $functions = $environment->getFunctions();
        $filters = $environment->getFilters();

        $this->resetExtensionInitialization($environment);

        $this->tolerantTwigFunctionFilterDecorator->decorate($environment, $functions, $filters);
    }

    private function resetExtensionInitialization(Environment $environment): void
    {
        // TWIG 2
        $extensionSet = $this->privatesAccessor->getPrivateProperty($environment, 'extensionSet');
        $this->privatesAccessor->setPrivateProperty($extensionSet, 'initialized', false);
        $this->privatesAccessor->setPrivateProperty($extensionSet, 'staging', new StagingExtension());
    }
}
