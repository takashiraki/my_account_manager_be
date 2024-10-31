<?php

declare(strict_types=1);

namespace User\Domain\User;

use Basic\DomainService\StringValueObject;
use InvalidArgumentException;

class UserPermission extends StringValueObject
{
    private array $permissions = [
        'admin',
        'viewer',
    ];

    public function __construct(
        string $value
    ) {
        if (empty($value) || trim($value) === '') {
            throw new InvalidArgumentException('Permission is required.');
        }
        
        if (! in_array($value, $this->permissions)) {
            throw new InvalidArgumentException('Permission is invalid.');
        }

        parent::__construct($value);
    }
}
