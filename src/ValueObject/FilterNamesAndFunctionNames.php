<?php

declare (strict_types=1);
namespace TomasVotruba\Torch\ValueObject;

final class FilterNamesAndFunctionNames
{
    /**
     * @var string[]
     * @readonly
     */
    private $filterNames;
    /**
     * @var string[]
     * @readonly
     */
    private $functionNames;
    /**
     * @param string[] $filterNames
     * @param string[] $functionNames
     */
    public function __construct(array $filterNames, array $functionNames)
    {
        $this->filterNames = $filterNames;
        $this->functionNames = $functionNames;
    }
    /**
     * @return string[]
     */
    public function getFilterNames() : array
    {
        return $this->filterNames;
    }
    /**
     * @return string[]
     */
    public function getFunctionNames() : array
    {
        return $this->functionNames;
    }
}
