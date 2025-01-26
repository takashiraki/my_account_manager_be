<?php

declare(strict_types=1);

namespace User\Domain\User;

interface UserDomainServiceInterface
{
    public function existById(UserId $id): bool;
    
    public function existByEmail(UserEmail $email): bool;

    public function existByNewEmail(UserEmail $email): bool;
}
