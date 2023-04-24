<?php

declare(strict_types=1);

namespace SmokedTwigRenderer\ValueObject;

final class FilterNamesAndFunctionNames
{
    /**
     * @var string[]
     */
    private $filterNames = [];

    /**
     * @var string[]
     */
    private $functionNames = [];

    /**
     * @param string[] $filterNames
     * @param string[] $functionNames
     */
    public function __construct(
        array $filterNames,
        array $functionNames
    ) {
        $this->filterNames = $filterNames;
        $this->functionNames = $functionNames;
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
