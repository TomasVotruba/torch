<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Reflection;

use Exception;
use ReflectionProperty;

final class PrivatesAccessor
{
    public function getPrivateProperty(object $object, string $propertyName)
    {
        $propertyReflection = $this->resolvePropertyReflection($object, $propertyName);
        $propertyReflection->setAccessible(true);

        return $propertyReflection->getValue($object);
    }

    public function setPrivateProperty(object $object, string $propertyName, $value): void
    {
        $propertyReflection = $this->resolvePropertyReflection($object, $propertyName);
        $propertyReflection->setAccessible(true);

        $propertyReflection->setValue($object, $value);
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

        $errorMessage = sprintf('Property "$%s" was not found in "%s" class', $propertyName, get_class($object));
        throw new Exception($errorMessage);
    }
}
