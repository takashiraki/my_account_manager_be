<?php

declare(strict_types=1);

namespace User\Domain\User;

enum UserPermissions: string
{
    case admin = 'admin';
    case viewer = 'viewer';
}
