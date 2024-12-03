<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Http\Requests\User\CreateUserRequest;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(Authenticate::class);
    }

    public function testBasicHandle(): void
    {
        $response = $this->post(
            '/api/user/store',
            [
                'name' => 'test',
                'email' => 'hogehoge@hogehoge.com',
                'permission' => 'admin',
            ]
        );

        $response->assertStatus(200);
    }

    public function testBasicHandleJson(): void
    {
        $response = $this->postJson(
            '/api/user/store',
            [
                'name' => 'test',
                'email' => config('mail.test.email'),
            ]
        );

        $response->assertJson([]);
    }

    #[DataProvider('dataProvider')]
    public function testRequestError(array $params, array $expected): void
    {
        $request = new CreateUserRequest();

        $rules = $request->rules();

        $result = validator($params, $rules)->getMessageBag()->get($expected['key']);

        $this->assertSame(
            $expected['item'],
            $result[array_search($expected['key'], array_keys($result), true)]
        );
    }

    public static function dataProvider(): array
    {
        return [
            [
                [
                    'name' => '',
                    'email' => 'hogehoge@hogehoge.com',
                    'permission' => 'admin',
                ],
                [
                    'key' => 'name',
                    'item' => '名前は必ず指定してください。',
                ],
            ],
            [
                [
                    'name' => 1,
                    'email' => 'hogehoge@hogehoge.com',
                    'permission' => 'admin',
                ],
                [
                    'key' => 'name',
                    'item' => '名前は文字列を指定してください。',
                ],
            ],
            [
                [
                    'name' => 'hogehogehogehogehogehogehogehogehogehogehogehogehoge',
                    'email' => 'hogehoge@hogehoge.com',
                    'permission' => 'admin',
                ],
                [
                    'key' => 'name',
                    'item' => '名前は、50文字以下で指定してください。',
                ],
            ],
            [
                [
                    'name' => 'hogehoge',
                    'email' => '',
                    'permission' => 'admin',
                ],
                [
                    'key' => 'email',
                    'item' => 'メールアドレスは必ず指定してください。',
                ],
            ],
            [
                [
                    'name' => 'hogehoge',
                    'email' => 1,
                    'permission' => 'admin',
                ],
                [
                    'key' => 'email',
                    'item' => 'メールアドレスには、有効なメールアドレスを指定してください。',
                ],
            ],
            [
                [
                    'name' => 'hogehoge',
                    'email' => Str::random(100) . '@hogehoge.com',
                    'permission' => 'admin',
                ],
                [
                    'key' => 'email',
                    'item' => 'メールアドレスには、有効なメールアドレスを指定してください。',
                ],
            ],
        ];
    }
}
