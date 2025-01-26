<?php

declare(strict_types=1);

namespace User\Domain\User;

use Basic\DomainService\StringValueObject;
use InvalidArgumentException;

class UserPermission extends StringValueObject
{
    public function __construct(
        string $value
    ) {
        if (empty($value) || trim($value) === '') {
            throw new InvalidArgumentException('Permission is required.');
        }
        
        if (($permission = UserPermissions::tryFrom($value)) === null) {
            throw new InvalidArgumentException('Permission is invalid.');
        }

        parent::__construct($permission->value);
    }

    public static function isExist(string $value): bool
    {
        return UserPermissions::tryFrom($value) !== null;
    }
}
