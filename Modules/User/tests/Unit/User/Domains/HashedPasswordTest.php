<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\User\Domains;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use User\Domain\User\HashedPassword;

class HashedPasswordTest extends TestCase
{
    public function testValidInstance(): void
    {
        $hashed_password = new HashedPassword('hogehogehogehogehogehogehogehogehoge');

        $this->assertInstanceOf(
            HashedPassword::class,
            $hashed_password
        );
    }

    public function testValidValue(): void
    {
        $hashed_password = new HashedPassword('hogehogehoge');

        $this->assertEquals(
            'hogehogehoge',
            $hashed_password->value()
        );
    }

    #[DataProvider('dataProvider')]
    public function testInvalidValue(array $data, array $expected): void
    {
        $this->expectException($expected['exception']);
        $this->expectExceptionMessage($expected['message']);
        new HashedPassword($data['value']);
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
                    'message' => 'Password needs any value.',
                ],
            ],
            [
                [
                    'value' => ' ',
                ],
                [
                    'exception' => InvalidArgumentException::class,
                    'message' => 'Password needs any value.',
                ],
            ],
        ];
    }
}
