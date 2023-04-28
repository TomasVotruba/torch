<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\ValueObject;

final class FilterNamesAndFunctionNames
{
    /**
     * @param string[] $filterNames
     * @param string[] $functionNames
     */
    public function __construct(
        private readonly array $filterNames,
        private readonly array $functionNames
    ) {
    }

    /**
     * @return string[]
     */
    public function getFilterNames(): array
    {
        return $this->filterNames;
    }

    /**
     * @return string[]
     */
    public function getFunctionNames(): array
    {
        return $this->functionNames;
    }
}
