<?php

declare(strict_types=1);

namespace App\Providers\ServiceProviders;

use Illuminate\Contracts\Foundation\Application;

class LocalServiceProvider implements ProviderInterface
{
    public function __construct(
        private Application $app
    ) {
    }

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
