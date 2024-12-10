<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\User\Domains;

use InvalidArgumentException;
use LengthException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use User\Domain\User\UserEmail;

class UserEmailTest extends TestCase
{
    public function testValidInstance(): void
    {
        $email = new UserEmail('hogehoge@hogehoge.com');

        $this->assertInstanceOf(
            UserEmail::class,
            $email
        );
    }

    public function testValidValue(): void
    {
        $email = new UserEmail('hogehoge@hogehoge.com');

        $this->assertEquals(
            'hogehoge@hogehoge.com',
            $email->value()
        );
    }

    #[DataProvider('dataProvider')]
    public function testException(array $params, array $expection): void
    {
        $this->expectException($expection['exception']);
        $this->expectExceptionMessage($expection['message']);

        new UserEmail($params['value']);
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
                    'message' => 'Email is required.',
                ],
            ],
            [
                [
                    'value' => ' ',
                ],
                [
                    'exception' => InvalidArgumentException::class,
                    'message' => 'Email is required.',
                ],
            ],
            [
                [
                    'value' => str_repeat('a', 101),
                ],
                [
                    'exception' => LengthException::class,
                    'message' => 'Email must be between 1 and 100 characters.',
                ],
            ],
        ];
    }
}
