<?php

declare(strict_types=1);

namespace User\Domain\User;

use Basic\DomainService\StringValueObject;
use InvalidArgumentException;

class HashedPassword extends StringValueObject
{
    private const MAX_LENGTH = 256;

    public function __construct(string $value)
    {
        if (empty($value) || trim($value) === '') {
            throw new InvalidArgumentException('Password needs any value.');
        }

        $length = mb_strlen($value);

        if ($length > self::MAX_LENGTH) {
            throw new InvalidArgumentException('Password must be less than ' . self::MAX_LENGTH . ' characters.');
        }

        parent::__construct($value);
    }
}
