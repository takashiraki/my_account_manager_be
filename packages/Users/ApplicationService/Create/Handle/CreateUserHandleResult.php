<?php

declare(strict_types=1);

namespace USer\ApplicationService\Create\Handle;

use User\Domain\User\User;

readonly class CreateUserHandleResult
{
    public static function success(User $user): self
    {
        return new self(user: $user);
    }

    public static function requestError(array $request_error_messages): self
    {
        return new self(request_error_messages: $request_error_messages);
    }

    public static function handleError(array $handle_error_messages): self
    {
        return new self(handle_error_messages: $handle_error_messages);
    }

    private function __construct(
        public User|null $user = null,
        public array|null $request_error_messages = null,
        public array|null $handle_error_messages = null,
    ) {
    }

    public function iserror(): bool
    {
        return $this->request_error_messages !== null || $this->handle_error_messages !== null;
    }
}
