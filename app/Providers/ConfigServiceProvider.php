<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\ConfigRepository;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            abstract: ConfigRepository::class,
            concrete: function () {
                $path = isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] == 'testing'
                    ? base_path('tests')
                    : ($_SERVER['HOME'] ?? $_SERVER['USERPROFILE']);

                $path .= "/.linode/config.json";

                return new ConfigRepository(
                    path: $path,
                );
            },
        );
    }
}
