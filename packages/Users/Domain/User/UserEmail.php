<?php

declare(strict_types=1);

namespace User\Domain\User;

use Basic\DomainService\StringValueObject;
use InvalidArgumentException;
use LengthException;

class UserEmail extends StringValueObject
{
    private const MIN_LENGTH = 1;

    private const MAX_LENGTH = 100;

    public function __construct(
        string $value
    ) {
        if (empty($value) || trim($value) === '') {
            throw new InvalidArgumentException('Email is required.');
        }

        $lemgth = mb_strlen($value);

        if ($lemgth < self::MIN_LENGTH || $lemgth > self::MAX_LENGTH) {
            throw new LengthException('Email must be between 1 and 100 characters.');
        }

        parent::__construct($value);
    }
}
