<?php

declare(strict_types=1);

namespace Tests\Unit\User\Domains;

use PHPUnit\Framework\TestCase;
use User\Domain\User\HashedPassword;
use User\Domain\User\User;
use User\Domain\User\UserEmail;
use User\Domain\User\UserId;
use User\Domain\User\UserName;
use User\Domain\User\UserPermission;

class UserTest extends TestCase
{
    public function testValidInstance(): void
    {
        $id = new UserId('hogehogehogehogehogehogehogehogehoge');
        $name = new UserName('hogehoge');
        $email = new UserEmail('hogehoge@hogehoge.com');
        $permission = new UserPermission('admin');
        $password = new HashedPassword('hogehogehogehogehogehogehogehogehoge');

        $user = new User(
            $id,
            $name,
            $email,
            $permission,
            $password
        );

        $this->assertInstanceOf(
            User::class,
            $user
        );
    }

    public function testValidValue(): void
    {
        $id = new UserId('hogehogehogehogehogehogehogehogehoge');
        $name = new UserName('hogehoge');
        $email = new UserEmail('hogehoge@hogehoge.com');
        $permission = new UserPermission('admin');
        $password = new HashedPassword('hogehogehogehogehogehogehogehogehoge');

        $user = new User(
            $id,
            $name,
            $email,
            $permission,
            $password
        );

        $this->assertEquals(
            'hogehogehogehogehogehogehogehogehoge',
            $user->userId()->value()
        );

        $this->assertEquals(
            'hogehoge',
            $user->userName()->value()
        );

        $this->assertEquals(
            'hogehoge@hogehoge.com',
            $user->userEmail()->value()
        );

        $this->assertEquals(
            'admin',
            $user->userPermission()->value()
        );

        $this->assertEquals(
            'hogehogehogehogehogehogehogehogehoge',
            $user->hashedPassword()->value()
        );
    }
}
