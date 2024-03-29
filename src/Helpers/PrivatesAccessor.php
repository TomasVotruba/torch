<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Helpers;

use ReflectionProperty;

final class PrivatesAccessor
{
    public static function propertyClosure(object $object, string $propertyName, callable $closure): void
    {
        $property = self::getPrivateProperty($object, $propertyName);

        // modify value
        $property = $closure($property);

        self::setPrivateProperty($object, $propertyName, $property);
    }

    public static function getPrivateProperty(object $object, string $propertyName): mixed
    {
        $reflectionProperty = new ReflectionProperty($object, $propertyName);
        $reflectionProperty->setAccessible(\true);

        return $reflectionProperty->getValue($object);
    }

    public static function setPrivateProperty(object $object, string $propertyName, mixed $value): void
    {
        $reflectionProperty = new ReflectionProperty($object, $propertyName);
        $reflectionProperty->setAccessible(\true);
        $reflectionProperty->setValue($object, $value);
    }
}
