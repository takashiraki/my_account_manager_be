<?php

declare(strict_types=1);

namespace User\Domain\User;

interface UserFactoryInterface
{
    public function create(
        string $id,
        string $name,
        string $email,
        string $permission,
        HashedPassword $password,
    ): User;

    public function createUserId(string $id): UserId;

    public function createUserEmail(string $email): UserEmail;
}
