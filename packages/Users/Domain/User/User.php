<?php

declare(strict_types=1);

namespace User\Domain\User;

class User
{
    public function __construct(
        private UserId $id,
        private UserName $name,
        private UserEmail $email,
        private UserPermission $permission
    ) {
    }

    public function userId(): UserId
    {
        return $this->id;
    }

    public function userName(): UserName
    {
        return $this->name;
    }

    public function userEmail(): UserEmail
    {
        return $this->email;
    }

    public function userPermission(): UserPermission
    {
        return $this->permission;
    }
}
