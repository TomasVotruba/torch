<?php

declare (strict_types=1);
namespace TomasVotruba\Torch\Twig;

use Torch202308\Symfony\Bridge\Twig\Extension\FormExtension;
use TomasVotruba\Torch\Contract\TwigEnvironmentDecoratorInterface;
use TomasVotruba\Torch\FileSystem\FileSystem;
use TomasVotruba\Torch\Reflection\PrivatesAccessor;
use TomasVotruba\Torch\Twig\TokenParser\TolerantFormThemeTokenParser;
use TomasVotruba\Torch\ValueObject\DummyTheme;
use Twig\Environment;
use Torch202308\Twig\Extension\StagingExtension;
use Torch202308\Twig\ExtensionSet;
use Torch202308\Twig\Loader\ArrayLoader;
use Torch202308\Twig\Loader\ChainLoader;
/**
 * @see \TomasVotruba\Torch\Tests\Twig\TolerantTwigEnvironmentTest
 */
final class TolerantTwigEnvironmentFactory
{
    /**
     * @readonly
     * @var \TomasVotruba\Torch\Reflection\PrivatesAccessor
     */
    private $privatesAccessor;
    /**
     * @readonly
     * @var \Twig\Environment
     */
    private $twigEnvironment;
    /**
     * @readonly
     * @var \TomasVotruba\Torch\Twig\TolerantTwigFunctionFilterDecorator
     */
    private $tolerantTwigFunctionFilterDecorator;
    /**
     * @var TwigEnvironmentDecoratorInterface[]
     * @readonly
     */
    private $twigEnvironmentDecorators;
    /**
     * @param TwigEnvironmentDecoratorInterface[] $twigEnvironmentDecorators
     */
    public function __construct(PrivatesAccessor $privatesAccessor, Environment $twigEnvironment, \TomasVotruba\Torch\Twig\TolerantTwigFunctionFilterDecorator $tolerantTwigFunctionFilterDecorator, array $twigEnvironmentDecorators)
    {
        $this->privatesAccessor = $privatesAccessor;
        $this->twigEnvironment = $twigEnvironment;
        $this->tolerantTwigFunctionFilterDecorator = $tolerantTwigFunctionFilterDecorator;
        $this->twigEnvironmentDecorators = $twigEnvironmentDecorators;
    }
    /**
     * @param string[] $twigFiles
     */
    public function create(array $twigFiles) : \TomasVotruba\Torch\Twig\TolerantTwigEnvironment
    {
        $environment = $this->twigEnvironment;
        $isolatedEnvironment = clone $environment;
        $this->resetExtensionInitialization($isolatedEnvironment);
        $this->decorateLoaderWithFiles($isolatedEnvironment, $twigFiles);
        // add tolerant functions and filters
        $this->decorateTolerantFiltersAndFunctions($isolatedEnvironment);
        $this->decorateTolerantFormThemeTag($isolatedEnvironment);
        // required to have tolerant twig, that have no variables
        $isolatedEnvironment->disableStrictVariables();
        // possible to get extended by end-user
        foreach ($this->twigEnvironmentDecorators as $twigEnvironmentDecorator) {
            $twigEnvironmentDecorator->decorate($isolatedEnvironment);
        }
        return new \TomasVotruba\Torch\Twig\TolerantTwigEnvironment($isolatedEnvironment);
    }
    /**
     * @param string[] $twigFiles
     */
    private function decorateLoaderWithFiles(Environment $twigEnvironment, array $twigFiles) : void
    {
        $originalLoader = $twigEnvironment->getLoader();
        $arrayLoader = new ArrayLoader();
        $chainLoader = new ChainLoader([$arrayLoader, $originalLoader]);
        // prepare loader with files so it can easily render
        foreach ($twigFiles as $name => $twigFile) {
            $twigFileContents = FileSystem::read($twigFile);
            if (\is_string($name)) {
                $arrayLoader->setTemplate($name, $twigFileContents);
            } else {
                $arrayLoader->setTemplate($twigFile, $twigFileContents);
            }
        }
        // dummy templates to re-use instead of dynamic ones
        $defaultLayoutContents = FileSystem::read(__DIR__ . '/../../templates/dummy_layout.twig');
        $arrayLoader->setTemplate(DummyTheme::LAYOUT_NAME, $defaultLayoutContents);
        $twigEnvironment->setLoader($chainLoader);
    }
    /**
     * @see https://gist.github.com/TomasVotruba/b3520601c474fbea0488cc74c08e18fb
     */
    private function decorateTolerantFiltersAndFunctions(Environment $twigEnvironment) : void
    {
        $twigEnvironment->addExtension(new FormExtension());
        // after we fetch these, the staging must be reset to the twig environment is not locked
        $functions = $twigEnvironment->getFunctions();
        $filters = $twigEnvironment->getFilters();
        $this->resetExtensionInitialization($twigEnvironment);
        $this->tolerantTwigFunctionFilterDecorator->decorate($twigEnvironment, $functions, $filters);
    }
    private function resetExtensionInitialization(Environment $twigEnvironment) : void
    {
        // TWIG 2
        /** @var ExtensionSet $extensionSet */
        $extensionSet = $this->privatesAccessor->getPrivateProperty($twigEnvironment, 'extensionSet');
        $this->privatesAccessor->setPrivateProperty($extensionSet, 'initialized', \false);
        $this->privatesAccessor->setPrivateProperty($extensionSet, 'staging', new StagingExtension());
    }
    private function decorateTolerantFormThemeTag(Environment $twigEnvironment) : void
    {
        $tolerantFormThemeTokenParser = new TolerantFormThemeTokenParser();
        $twigEnvironment->addTokenParser($tolerantFormThemeTokenParser);
    }
}
