<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Twig;

use Symfony\Component\Form\FormFactoryInterface;
use TomasVotruba\Torch\Form\SimpleFormType;
use Twig\Environment;
use Twig\Loader\LoaderInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Webmozart\Assert\Assert;

/**
 * This class is a tolerant wrapper around Twig\Environment.
 *
 * What does "tolerant" mean? The functions/filters can accept variable as null.
 * It allows to render any templates without variables. This allows semi-dynamic analysis of template,
 * checks errors and oppose to simple linter, also validates the bundle configuration, all twig extensions and so on.
 *
 * @see \TomasVotruba\Torch\Tests\Twig\TolerantTwigEnvironmentTest
 */
final class TolerantTwigEnvironment
{
    public function __construct(
        private readonly Environment $environment,
        private readonly FormFactoryInterface $formFactory
    ) {
    }

    /**
     * @param array<string, mixed> $context
     */
    public function render(string $name, array $context = []): string
    {
        // add dummy form to allow simple renders
        if (! isset($context['form'])) {
            $simpleFormType = $this->formFactory->create(SimpleFormType::class);
            $context['form'] = $simpleFormType->createView();
        }

        return $this->environment->render($name, $context);
    }

    /**
     * @api used in tests
     */
    public function getLoader(): LoaderInterface
    {
        return $this->environment->getLoader();
    }

    public function getFunction(string $functionName): TwigFunction
    {
        $twigFunction = $this->environment->getFunction($functionName);
        Assert::isInstanceOf($twigFunction, TwigFunction::class);

        return $twigFunction;
    }

    public function getFilter(string $filterName): TwigFilter
    {
        $twigFilter = $this->environment->getFilter($filterName);
        Assert::isInstanceOf($twigFilter, TwigFilter::class);

        return $twigFilter;
    }
}
