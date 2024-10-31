<?php

declare(strict_types=1);

namespace Basic\DomainService;

use InvalidArgumentException;

abstract class StringValueObject
{
    public function __construct(
        private string $value
    ) {
        if (empty($value) || trim($value) === '') {
            throw new InvalidArgumentException('Value is required.');
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(StringValueObject $object): bool
    {
        return $this->value() === $object->value();
    }
}
