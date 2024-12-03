<?php

declare(strict_types=1);

namespace App\Providers\ServiceProviders;

use Illuminate\Contracts\Foundation\Application;
use User\StubGenerator\Create\Handle\StubCreateUserHandleGenerator;
use User\UseCase\Create\Handle\CreateUserHandleRequester;

class LocalServiceProvider implements ProviderInterface
{
    public function __construct(
        private Application $app
    ) {
    }

    public function register(): void
    {
        $this->user();
    }

    public function boot(): void
    {
        //
    }

    private function user(): void
    {
        $this->app->bind(
            CreateUserHandleRequester::class,
            StubCreateUserHandleGenerator::class
        );
    }
}
