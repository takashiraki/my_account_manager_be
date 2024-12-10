<?php

declare(strict_types=1);

namespace User\UseCase\Create\Handle;

readonly class CreateUserHandleRequest
{
    public function __construct(
        public string $name,
        public string $email,
        public string $permission
    ) {
    }
}
