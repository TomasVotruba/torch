<?php

declare (strict_types=1);
namespace TomasVotruba\Torch\Twig;

use Symfony\Bridge\Twig\Extension\FormExtension;
use TomasVotruba\Torch\ValueObject\FilterNamesAndFunctionNames;
use Twig\Environment;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;
final class TwigCoreFunctionsAndFiltersResolver
{
    public function resolve(Environment $twigEnvironment) : FilterNamesAndFunctionNames
    {
        $coreExtensions = $this->resolveCoreExtensions($twigEnvironment);
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
    private function resolveCoreExtensions(Environment $twigEnvironment) : array
    {
        $coreExtensions = [];
        foreach ($twigEnvironment->getExtensions() as $extension) {
            // override all form functions
            if ($extension instanceof FormExtension) {
                continue;
            }
            $extensionClass = \get_class($extension);
            // core extensions
            if (\strncmp($extensionClass, 'Symfony', \strlen('Symfony')) === 0 || \strncmp($extensionClass, 'Twig', \strlen('Twig')) === 0) {
                $coreExtensions[] = $extension;
            }
        }
        return $coreExtensions;
    }
}
