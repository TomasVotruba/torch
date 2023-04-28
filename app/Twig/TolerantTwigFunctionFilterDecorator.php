<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Twig;

use TomasVotruba\Torch\Contract\EnvironmentDecoratorInterface;
use TomasVotruba\Torch\Exception\TwigConstantNotFoundException;
use TomasVotruba\Torch\ValueObject\FilterNamesAndFunctionNames;
use Twig\Environment;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Webmozart\Assert\Assert;

/**
 * @see \TomasVotruba\Torch\Tests\Twig\TolerantTwigFunctionFilterDecoratorTest
 */
final class TolerantTwigFunctionFilterDecorator
{
    public function __construct(
        private readonly TwigCoreFunctionsAndFiltersResolver $twigCoreFunctionsAndFiltersResolver,
        private readonly ?\TomasVotruba\Torch\Contract\EnvironmentDecoratorInterface $environmentDecorator = null
    ) {
    }

    /**
     * @param TwigFunction[] $functions
     * @param TwigFilter[] $filters
     */
    public function decorate(Environment $environment, array $functions, array $filters): void
    {
        /** @see inspiration https://gist.github.com/TomasVotruba/b3520601c474fbea0488cc74c08e18fb */
        $coreFilterNamesAndFunctionsNames = $this->twigCoreFunctionsAndFiltersResolver->resolve($environment);

        $functionsToSkip = config('parameters.functions_to_skip');

        Assert::isArray($functionsToSkip);
        Assert::allString($functionsToSkip);

        $this->decorateTolerantFunctions($functions, $coreFilterNamesAndFunctionsNames, $environment, $functionsToSkip);
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
                $environment->addFunction(new TwigFunction($functionName, fn () => ''));
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
                $environment->addFilter(new TwigFilter($filterName, fn () => ''));
            }
        }
    }

    private function addValidatedConstantFilter(Environment $environment): void
    {
        /** @see vendor/twig/twig/src/Extension/CoreExtension.php:1654 */
        // special case to validate constants exists
        $constantTwigFunction = new TwigFunction('constant', function ($constant, $object = null) {
            if ($object !== null) {
                $constant = $object::class . '::' . $constant;
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
