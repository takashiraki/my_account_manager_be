<?php

declare(strict_types=1);

namespace Users\StubGenerator\Create\Handle;

use User\UseCase\Create\Handle\CreateUserHandleRequest;
use User\UseCase\Create\Handle\CreateUserHandleRequester;
use User\UseCase\Create\Handle\CreateUserHandleResponse;

class StubCreateUserHandleGenerator implements CreateUserHandleRequester
{
    public function handle(CreateUserHandleRequest $request): CreateUserHandleResponse
    {
        return new CreateUserHandleResponse();
    }
}
