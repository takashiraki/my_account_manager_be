<?php

declare(strict_types=1);

namespace User\Presenter\Create\Handle;

use User\UseCase\Create\Handle\CreateUserHandleResponse;

interface CreateUserHandlePresenterInterface
{
    public function output(CreateUserHandleResponse $response): mixed;
}
