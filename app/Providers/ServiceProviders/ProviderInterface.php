<?php

declare(strict_types=1);

namespace App\Providers\ServiceProviders;

interface ProviderInterface
{
    public function register(): void;

    public function boot(): void;
}
