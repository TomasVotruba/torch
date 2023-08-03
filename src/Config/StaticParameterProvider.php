<?php

declare (strict_types=1);
namespace Torch202308\TomasVotruba\Torch\Config;

final class StaticParameterProvider
{
    /**
     * @var array<string, mixed>
     */
    private static $parameters = [];
    /**
     * @param mixed $value
     */
    public static function set(string $name, $value) : void
    {
        self::$parameters[$name] = $value;
    }
    /**
     * @return mixed
     */
    public static function get(string $name)
    {
        return self::$parameters[$name] ?? null;
    }
}
