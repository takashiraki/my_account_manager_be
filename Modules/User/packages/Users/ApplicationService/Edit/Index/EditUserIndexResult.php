<?php

declare(strict_types=1);

namespace User\ApplicationService\Edit\Index;

readonly class EditUserIndexResult
{
    public static function success(): self
    {
        return new self(null);
    }

    public static function requestError(array $request_error_messages): self
    {
        return new self($request_error_messages);
    }
    
    private function __construct(
        public array|null $request_error_messages
    ) {
    }

    public function isError(): bool
    {
        return $this->request_error_messages !== null;
    }
}
