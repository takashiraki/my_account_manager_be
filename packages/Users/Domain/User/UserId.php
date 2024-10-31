<?php

declare(strict_types=1);

namespace User\Domain\User;

use Basic\DomainService\StringValueObject;
use InvalidArgumentException;
use LengthException;

class UserId extends StringValueObject
{
    private const LENGTH = 36;

    public function __construct(
        string $value
    ) {
        if (empty($value) || trim($value) === '') {
            throw new InvalidArgumentException('User id is required.');
        }

        if (strlen($value) !== self::LENGTH) {
            throw new LengthException('User id must be 36 characters.');
        }

        parent::__construct($value);
    }
}
