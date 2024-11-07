<?php

declare(strict_types=1);

namespace User\UseCase\Create\Handle;

readonly class CreateUserHandleResponse
{
    public function __construct(
        public array|null $request_error_messages = null,
        public array|null $handle_error_messages = null,
    ) {
    }
}
