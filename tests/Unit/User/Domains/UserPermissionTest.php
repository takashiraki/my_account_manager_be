<?php

declare(strict_types=1);

namespace Tests\Unit\User\Domains;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use User\Domain\User\UserPermission;

class UserPermissionTest extends TestCase
{
    public function testValidInstance(): void
    {
        $email = new UserPermission('admin');

        $this->assertInstanceOf(
            UserPermission::class,
            $email
        );
    }

    public function testValidValue(): void
    {
        $email = new UserPermission('admin');

        $this->assertEquals(
            'admin',
            $email->value()
        );
    }

    #[DataProvider('dataProvider')]
    public function testException(array $params, array $expection): void
    {
        $this->expectException($expection['exception']);
        $this->expectExceptionMessage($expection['message']);

        new UserPermission($params['value']);
    }

    public static function dataProvider(): array
    {
        return [
            [
                [
                    'value' => '',
                ],
                [
                    'exception' => InvalidArgumentException::class,
                    'message' => 'Permission is required.',
                ],
            ],
            [
                [
                    'value' => ' ',
                ],
                [
                    'exception' => InvalidArgumentException::class,
                    'message' => 'Permission is required.',
                ],
            ],
            [
                [
                    'value' => 'hogehoge',
                ],
                [
                    'exception' => InvalidArgumentException::class,
                    'message' => 'Permission is invalid.',
                ],
            ],
        ];
    }
}
