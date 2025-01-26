<?php

declare(strict_types=1);

namespace User\ApplicationService\Edit\Handle;

readonly class EditUserHandleResult
{
    public static function success(): self
    {
        return new self(null, null);
    }

    public static function requestError(array $request_error_messages): self
    {
        return new self(request_error_messages: $request_error_messages, handle_error_messages: null);
    }

    public static function handleError(array $handle_error_messages): self
    {
        return new self(request_error_messages: null, handle_error_messages: $handle_error_messages);
    }

    private function __construct(
        public array|null $request_error_messages,
        public array|null $handle_error_messages,
    ) {
    }

    public function isError(): bool
    {
        return $this->request_error_messages !== null || $this->handle_error_messages !== null;
    }
}
