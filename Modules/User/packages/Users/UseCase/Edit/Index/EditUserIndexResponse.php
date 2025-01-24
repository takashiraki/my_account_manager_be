<?php

declare(strict_types=1);

namespace User\UseCase\Edit\Index;

use User\ApplicationService\Edit\Index\EditUserIndexResult;
use User\Domain\User\User;

readonly class EditUserIndexResponse
{
    public function __construct(
        public EditUserIndexResult $result,
        public User|null $user = null
    ) {
    }
}
