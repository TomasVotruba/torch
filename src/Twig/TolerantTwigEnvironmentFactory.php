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
    private Environment $environment;

    private PrivatesAccessor $privatesAccessor;

    private TolerantTwigFunctionFilterDecorator $tolerantTwigFunctionFilterDecorator;

    private FormFactoryInterface $formFactory;

    public function __construct(
        Environment $environment,
        PrivatesAccessor $privatesAccessor,
        TolerantTwigFunctionFilterDecorator $tolerantTwigFunctionFilterDecorator,
        FormFactoryInterface $formFactory
    ) {
        $this->environment = $environment;
        $this->privatesAccessor = $privatesAccessor;
        $this->tolerantTwigFunctionFilterDecorator = $tolerantTwigFunctionFilterDecorator;
        $this->formFactory = $formFactory;
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
            if (is_string($name)) {
                $arrayLoader->setTemplate($name, FileSystem::read($twigFile));
            } else {
                $arrayLoader->setTemplate($twigFile, FileSystem::read($twigFile));
            }
        }

        // dummy templates to re-use instead of dynamic ones
        $arrayLoader->setTemplate(DummyTheme::LAYOUT_NAME, file_get_contents(__DIR__ . '/../../templates/dummy_layout.twig'));

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
