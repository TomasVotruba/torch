<?php

declare(strict_types=1);

use Illuminate\Config\Repository;

/**
 * laravel/support mirror, with useless class load
 * @see https://github.com/laravel/framework/blob/ce0ae3539ada94ddf1a2ecc844197b267fd27b6d/src/Illuminate/Foundation/helpers.php#L254-L276*
 */
if (! function_exists('config')) {
    /**
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of
     * configurations.
     *
     * @param array<string, mixed>|string $key
     * @return mixed|\Illuminate\Config\Repository|void
     */
    function config(array|string $key, mixed $default = null)
    {
        static $configRepository;

        if (! $configRepository instanceof Repository) {
            $configRepository = new Repository();
        }

        if (is_array($key)) {
            $configRepository->set($key);
            return;
        }

        return $configRepository->get($key, $default);
    }
}
