<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\User\Domains;

use InvalidArgumentException;
use LengthException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use User\Domain\User\UserName;

class UserNameTest extends TestCase
{
    public function testvalidInstance(): void
    {
        $user_name = new UserName('hogehoge');

        $this->assertInstanceOf(
            UserName::class,
            $user_name
        );
    }

    public function testValidValue(): void
    {
        $user_name = new UserName('hogehoge');

        $this->assertEquals(
            'hogehoge',
            $user_name->value()
        );
    }

    #[DataProvider('dataProvider')]
    public function testException(array $params, array $expected): void
    {
        $this->expectException($expected['exception']);
        $this->expectExceptionMessage($expected['message']);

        new UserName($params['value']);
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
                    'message' => 'Name is required.',
                ],
            ],
            [
                [
                    'value' => ' ',
                ],
                [
                    'exception' => InvalidArgumentException::class,
                    'message' => 'Name is required.',
                ],
            ],
            [
                [
                    'value' => 'hogehogehogehogehogehoge',
                ],
                [
                    'exception' => LengthException::class,
                    'message' => 'Name must be between 1 and 20 characters.',
                ],
            ],
        ];
    }
}
