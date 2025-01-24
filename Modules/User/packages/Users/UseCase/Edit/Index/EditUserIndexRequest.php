<?php

declare(strict_types=1);

namespace User\UseCase\Edit\Index;

readonly class EditUserIndexRequest
{
    public function __construct(
        public string $id
    ) {
    }
}
