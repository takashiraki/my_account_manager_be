<?php

declare(strict_types=1);

namespace User\UseCase\Create\Handle;

interface CreateUserHandleRequester
{
    public function handle(CreateUserHandleRequest $request): CreateUserHandleResponse;
}
