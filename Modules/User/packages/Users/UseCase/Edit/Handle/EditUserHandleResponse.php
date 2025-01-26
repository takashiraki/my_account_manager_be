<?php

declare(strict_types=1);

namespace User\UseCase\Edit\Handle;

use User\ApplicationService\Edit\Handle\EditUserHandleResult;

readonly class EditUserHandleResponse
{
    public function __construct(
        public EditUserHandleResult $result
    ) {
    }
}
