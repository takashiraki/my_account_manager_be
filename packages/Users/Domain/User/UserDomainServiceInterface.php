<?php

declare(strict_types=1);

namespace User\Domain\User;

interface UserDomainServiceInterface
{
    public function existByEmail(UserEmail $email): bool;
}
