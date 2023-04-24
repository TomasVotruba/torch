<?php

declare(strict_types=1);

namespace SmokedTwigRenderer\Twig;

use SmokedTwigRenderer\Form\SimpleFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Twig\Environment;
use Twig\Loader\LoaderInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * This class is a tolerant wrapper around Twig\Environment.
 *
 * What does "tolerant" mean? The functions/filters can accept variable as null.
 * It allows to render any templates without variables. This allows semi-dynamic analysis of template,
 * checks errors and oppose to simple linter, also validates the bundle configuration, all twig extensions and so on.
 *
 * @see \SmokedTwigRenderer\Tests\Twig\TolerantTwigEnvironmentTest
 */
final class TolerantTwigEnvironment
{
    private FormFactoryInterface $formFactory;

    private Environment $environment;

    public function __construct(
        Environment $environment,
        FormFactoryInterface $formFactory
    ) {
        $this->formFactory = $formFactory;
        $this->environment = $environment;
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
        return $this->environment->getFunction($functionName);
    }

    public function getFilter(string $filterName): TwigFilter
    {
        return $this->environment->getFilter($filterName);
    }
}
