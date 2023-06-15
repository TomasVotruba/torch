<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Reflection;

use Exception;
use ReflectionProperty;

final class PrivatesAccessor
{
    public function getPrivateProperty(object $object, string $propertyName): mixed
    {
        $reflectionProperty = $this->resolvePropertyReflection($object, $propertyName);
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty->getValue($object);
    }

    public function setPrivateProperty(object $object, string $propertyName, mixed $value): void
    {
        $reflectionProperty = $this->resolvePropertyReflection($object, $propertyName);
        $reflectionProperty->setAccessible(true);

        $reflectionProperty->setValue($object, $value);
    }

    private function resolvePropertyReflection(object $object, string $propertyName): ReflectionProperty
    {
        if (property_exists($object, $propertyName)) {
            return new ReflectionProperty($object, $propertyName);
        }

        $parentClass = get_parent_class($object);
        if (is_string($parentClass)) {
            return new ReflectionProperty($parentClass, $propertyName);
        }

        $errorMessage = sprintf('Property "$%s" was not found in "%s" class', $propertyName, $object::class);
        throw new Exception($errorMessage);
    }
}
