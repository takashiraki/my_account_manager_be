<?php

declare(strict_types=1);

namespace User\UseCase\Create\Handle;

use USer\ApplicationService\Create\Handle\CreateUserHandleResult;

readonly class CreateUserHandleResponse
{
    public function __construct(
        public CreateUserHandleResult $result
    ) {
    }
}
