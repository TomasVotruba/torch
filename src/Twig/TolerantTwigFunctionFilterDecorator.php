<?php

declare(strict_types=1);

namespace SmokedTwigRenderer\Twig;

use SmokedTwigRenderer\Contract\EnvironmentDecoratorInterface;
use SmokedTwigRenderer\Enum\ParameterName;
use SmokedTwigRenderer\Exception\TwigConstantNotFoundException;
use SmokedTwigRenderer\ValueObject\FilterNamesAndFunctionNames;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Environment;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * @see \SmokedTwigRenderer\Tests\Twig\TolerantTwigFunctionFilterDecoratorTest
 */
final class TolerantTwigFunctionFilterDecorator
{
    private TwigCoreFunctionsAndFiltersResolver $twigCoreFunctionsAndFiltersResolver;

    private ParameterBagInterface $parameterBag;

    private ?EnvironmentDecoratorInterface $environmentDecorator = null;

    public function __construct(
        TwigCoreFunctionsAndFiltersResolver $twigCoreFunctionsAndFiltersResolver,
        ParameterBagInterface $parameterBag,
        ?EnvironmentDecoratorInterface $environmentDecorator = null
    ) {
        $this->twigCoreFunctionsAndFiltersResolver = $twigCoreFunctionsAndFiltersResolver;
        $this->parameterBag = $parameterBag;
        $this->environmentDecorator = $environmentDecorator;
    }

    /**
     * @param TwigFunction[] $functions
     * @param TwigFilter[] $filters
     */
    public function decorate(Environment $environment, array $functions, array $filters): void
    {
        /** @see inspiration https://gist.github.com/TomasVotruba/b3520601c474fbea0488cc74c08e18fb */
        $coreFilterNamesAndFunctionsNames = $this->twigCoreFunctionsAndFiltersResolver->resolve($environment);

        $skippedFunctionNames = $this->parameterBag->get(ParameterName::FUNCTIONS_TO_SKIP);

        $this->decorateTolerantFunctions($functions, $coreFilterNamesAndFunctionsNames, $environment, $skippedFunctionNames);
        $this->decorateTolerantFilters($filters, $coreFilterNamesAndFunctionsNames, $environment);

        if (! $this->environmentDecorator instanceof EnvironmentDecoratorInterface) {
            return;
        }

        $this->environmentDecorator->decorate($environment);
    }

    /**
     * @param TwigFunction[] $functions
     * @param string[] $skippedFunctionNames
     */
    private function decorateTolerantFunctions(
        array $functions,
        FilterNamesAndFunctionNames $filterNamesAndFunctionsNames,
        Environment $environment,
        array $skippedFunctionNames
    ): void {
        foreach ($functions as $functionName => $function) {
            if (in_array($functionName, $skippedFunctionNames, true)) {
                continue;
            }

            if ($functionName === 'constant') {
                $this->addValidatedConstantFilter($environment);

                continue;
            }

            if (in_array($functionName, $filterNamesAndFunctionsNames->getFunctionNames(), true)) {
                // keep as important
                $environment->addFunction($function);
            } else {
                $environment->addFunction(new TwigFunction($functionName, function () {
                    return '';
                }));
            }
        }
    }

    /**
     * @param TwigFilter[] $filters
     */
    private function decorateTolerantFilters(array $filters, FilterNamesAndFunctionNames $filterNamesAndFunctionsNames, Environment $environment): void
    {
        foreach ($filters as $filterName => $filter) {
            if (in_array($filterName, $filterNamesAndFunctionsNames->getFilterNames(), true)) {
                // keep as important
                $environment->addFilter($filter);
            } else {
                $environment->addFilter(new TwigFilter($filterName, function () {
                    return '';
                }));
            }
        }
    }

    private function addValidatedConstantFilter(Environment $environment): void
    {
        /** @see vendor/twig/twig/src/Extension/CoreExtension.php:1654 */
        // special case to validate constants exists
        $constantTwigFunction = new TwigFunction('constant', function ($constant, $object = null) {
            if ($object !== null) {
                $constant = \get_class($object) . '::' . $constant;
            }

            if (defined($constant) === false) {
                $errorMessage = sprintf('Constant "%s" was not found', $constant);
                throw new TwigConstantNotFoundException($errorMessage);
            }

            return constant($constant);
        });

        $environment->addFunction($constantTwigFunction);
    }
}
