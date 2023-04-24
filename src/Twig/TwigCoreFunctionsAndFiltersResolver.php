<?php

declare(strict_types=1);

namespace SmokedTwigRenderer\Twig;

use SmokedTwigRenderer\ValueObject\FilterNamesAndFunctionNames;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Twig\Environment;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class TwigCoreFunctionsAndFiltersResolver
{
    public function resolve(Environment $environment): FilterNamesAndFunctionNames
    {
        $coreExtensions = $this->resolveCoreExtensions($environment);

        $functionNames = [];
        $filterNames = [];

        foreach ($coreExtensions as $coreExtension) {
            foreach ($coreExtension->getFunctions() as $function) {
                /** @var TwigFunction $function */
                $functionNames[] = $function->getName();
            }

            foreach ($coreExtension->getFilters() as $filter) {
                /** @var TwigFilter $filter */
                $filterNames[] = $filter->getName();
            }
        }

        return new FilterNamesAndFunctionNames($filterNames, $functionNames);
    }

    /**
     * @return ExtensionInterface[]
     */
    private function resolveCoreExtensions(Environment $environment): array
    {
        $coreExtensions = [];
        foreach ($environment->getExtensions() as $extension) {
            // override all form functions
            if ($extension instanceof FormExtension) {
                continue;
            }

            $extensionClass = get_class($extension);

            // core extensions
            if (strpos($extensionClass, 'Symfony') === 0 || strpos($extensionClass, 'Twig') === 0) {
                $coreExtensions[] = $extension;
            }
        }

        return $coreExtensions;
    }
}
