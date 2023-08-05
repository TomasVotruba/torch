<?php

declare (strict_types=1);
namespace TomasVotruba\Torch\Twig;

use TomasVotruba\Torch\Config\StaticParameterProvider;
use TomasVotruba\Torch\Exception\TwigConstantNotFoundException;
use TomasVotruba\Torch\ValueObject\FilterNamesAndFunctionNames;
use Torch202308\Twig\Environment;
use Torch202308\Twig\TwigFilter;
use Torch202308\Twig\TwigFunction;
use Torch202308\Webmozart\Assert\Assert;
/**
 * @see \TomasVotruba\Torch\Tests\Twig\TolerantTwigFunctionFilterDecoratorTest
 */
final class TolerantTwigFunctionFilterDecorator
{
    /**
     * @readonly
     * @var \TomasVotruba\Torch\Twig\TwigCoreFunctionsAndFiltersResolver
     */
    private $twigCoreFunctionsAndFiltersResolver;
    public function __construct(\TomasVotruba\Torch\Twig\TwigCoreFunctionsAndFiltersResolver $twigCoreFunctionsAndFiltersResolver)
    {
        $this->twigCoreFunctionsAndFiltersResolver = $twigCoreFunctionsAndFiltersResolver;
    }
    /**
     * @param TwigFunction[] $functions
     * @param TwigFilter[] $filters
     */
    public function decorate(Environment $twigEnvironment, array $functions, array $filters) : void
    {
        /** @see inspiration https://gist.github.com/TomasVotruba/b3520601c474fbea0488cc74c08e18fb */
        $filterNamesAndFunctionNames = $this->twigCoreFunctionsAndFiltersResolver->resolve($twigEnvironment);
        $functionsToSkip = StaticParameterProvider::get('parameters.functions_to_skip');
        Assert::isArray($functionsToSkip);
        Assert::allString($functionsToSkip);
        $this->decorateTolerantFunctions($functions, $filterNamesAndFunctionNames, $twigEnvironment, $functionsToSkip);
        $this->decorateTolerantFilters($filters, $filterNamesAndFunctionNames, $twigEnvironment);
    }
    /**
     * @param TwigFunction[] $functions
     * @param string[] $skippedFunctionNames
     */
    private function decorateTolerantFunctions(array $functions, FilterNamesAndFunctionNames $filterNamesAndFunctionNames, Environment $twigEnvironment, array $skippedFunctionNames) : void
    {
        foreach ($functions as $functionName => $function) {
            if (\in_array($functionName, $skippedFunctionNames, \true)) {
                continue;
            }
            if ($functionName === 'constant') {
                $this->addValidatedConstantFilter($twigEnvironment);
                continue;
            }
            if (\in_array($functionName, $filterNamesAndFunctionNames->getFunctionNames(), \true)) {
                // keep as important
                $twigEnvironment->addFunction($function);
            } else {
                $twigEnvironment->addFunction(new TwigFunction($functionName, static function () : string {
                    return '';
                }));
            }
        }
    }
    /**
     * @param TwigFilter[] $filters
     */
    private function decorateTolerantFilters(array $filters, FilterNamesAndFunctionNames $filterNamesAndFunctionNames, Environment $twigEnvironment) : void
    {
        foreach ($filters as $filterName => $filter) {
            if (\in_array($filterName, $filterNamesAndFunctionNames->getFilterNames(), \true)) {
                // keep as important
                $twigEnvironment->addFilter($filter);
            } else {
                $twigEnvironment->addFilter(new TwigFilter($filterName, static function () : string {
                    return '';
                }));
            }
        }
    }
    private function addValidatedConstantFilter(Environment $twigEnvironment) : void
    {
        /** @see vendor/twig/twig/src/Extension/CoreExtension.php:1654 */
        // special case to validate constants exists
        $constantTwigFunction = new TwigFunction('constant', static function ($constant, $object = null) {
            if ($object !== null) {
                $constant = \get_class($object) . '::' . $constant;
            }
            if (!\defined($constant)) {
                $errorMessage = \sprintf('Constant "%s" was not found', $constant);
                throw new TwigConstantNotFoundException($errorMessage);
            }
            return \constant($constant);
        });
        $twigEnvironment->addFunction($constantTwigFunction);
    }
}
