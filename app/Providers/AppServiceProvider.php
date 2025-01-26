<?php

declare(strict_types=1);

namespace App\Providers;

use App\Providers\ServiceProviders\LocalServiceProvider;
use App\Providers\ServiceProviders\ProviderInterface;
use Exception;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->provider()->register();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function provider(): ProviderInterface
    {
        $env = config('app.env');

        switch ($env) {
            case 'local':
                return new LocalServiceProvider($this->app);
            default:
                throw new Exception('Invalid environment');
        }
    }
}
