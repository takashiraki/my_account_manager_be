<?php

declare(strict_types=1);

namespace User\ApplicationService\Create;

use App\Models\User;
use Exception;
use illuminate\Support\Str;

class CreateUserHandleService
{
    public function handle(
        string $name,
        string $email,
        string $permission
    ) {
        $validate = [
            'name' => $name,
            'email' => $email,
            'permission' => $permission,
        ];

        if (User::where('email', $validate['email'])->first()) {
            throw new Exception('Email already exists.', 409);
        }

        User::create(
            [
                'user_id' => (string)Str::uuid(),
                'user_name' => $validate['name'],
                'email' => $validate['email'],
                'permission' => $validate['permission'],
                'password' => bcrypt(Str::random(10)),
            ]
        );
    }
}
