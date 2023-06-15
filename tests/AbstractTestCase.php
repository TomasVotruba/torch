<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Tests;

use Illuminate\Container\Container;
use PHPUnit\Framework\TestCase;
use TomasVotruba\Torch\Container\TorchContainerFactory;
use Webmozart\Assert\Assert;

abstract class AbstractTestCase extends TestCase
{
    protected Container $container;

    protected function setUp(): void
    {
        $torchContainerFactory = new TorchContainerFactory();
        $this->container = $torchContainerFactory->create();
    }

    /**
     * @template TType as object
     * @param class-string<TType> $type
     * @return TType
     */
    protected function make(string $type): object
    {
        $service = $this->container->get($type);
        Assert::isInstanceOf($service, $type);

        return $service;
    }
}
