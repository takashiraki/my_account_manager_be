<?php

declare(strict_types=1);

namespace User\Domain\User;

interface UserRepositoryInterface
{
    public function create(User $user): void;
}