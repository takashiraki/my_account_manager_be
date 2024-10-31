<?php

declare(strict_types=1);

namespace Tests\Unit\User\Domains;

use InvalidArgumentException;
use LengthException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use User\Domain\User\UserId;

class UserIdTest extends TestCase
{
    public function testUserId(): void
    {
        $user_id = new UserId('hogehogehogehogehogehogehogehogehoge');

        $this->assertInstanceOf(UserId::class, $user_id);
    }

    public function testReturnValue(): void
    {
        $user_id = new UserId('hogehogehogehogehogehogehogehogehoge');

        $this->assertEquals('hogehogehogehogehogehogehogehogehoge', $user_id->value());
    }

    #[DataProvider('dataProvider')]
    public function testInvalidUserId(array $params, array $error): void
    {
        $this->expectException($error['exception']);
        $this->expectExceptionMessage($error['message']);

        new UserId($params['user_id']);
    }

    public static function dataProvider(): array
    {
        return [
            [
                [
                    'user_id' => ' ',
                ],
                [
                    'exception' => InvalidArgumentException::class,
                    'message' => 'User id is required.',
                ],
            ],
            [
                [
                    'user_id' => '',
                ],
                [
                    'exception' => InvalidArgumentException::class,
                    'message' => 'User id is required.',
                ],
            ],
            [
                [
                    'user_id' => 'hogehogehogehogehogehogehogehogehogehoge',
                ],
                [
                    'exception' => LengthException::class,
                    'message' => 'User id must be 36 characters.',
                ],
            ],
            [
                [
                    'user_id' => 'hogehogehogehogehogehogehogehoge',
                ],
                [
                    'exception' => LengthException::class,
                    'message' => 'User id must be 36 characters.',
                ],
            ],
        ];
    }
}
