<?php

declare(strict_types=1);

namespace User\UseCase\Edit\Handle;

readonly class EditUserHandleRequest
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $permission,
    ) {
    }
}
