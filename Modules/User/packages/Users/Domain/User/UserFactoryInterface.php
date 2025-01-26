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
    ): User;

    public function createUserId(string $id): UserId;

    public function createUserEmail(string $email): UserEmail;

    public function createUserPermission(string $permission): UserPermission;
}
