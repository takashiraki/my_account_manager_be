<?php

declare(strict_types=1);

namespace User\Domain\User;

interface PasswordHasherInterface
{
    public function hash(string $password): HashedPassword;
}
