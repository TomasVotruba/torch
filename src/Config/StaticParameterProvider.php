<?php

declare(strict_types=1);

namespace TomasVotruba\Torch\Config;

final class StaticParameterProvider
{
    /**
     * @var array<string, mixed>
     */
    private static array $parameters = [];

    public static function set(string $name, mixed $value): void
    {
        self::$parameters[$name] = $value;
    }

    public static function get(string $name): mixed
    {
        return self::$parameters[$name] ?? null;
    }
}
