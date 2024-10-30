<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use illuminate\Support\Str;

class CreateUserController extends Controller
{
    public function handle(
        Request $http_request
    ) {
        $validate = $http_request->validate(
            [
                'name' => ['required', 'string', 'between:1,20'],
                'email' => ['required', 'email:filter,dns', 'between:1,100'],
                'permission' => ['required', 'in:admin,employee,viewer', 'between:1,100'],
            ]
        );

        if (User::where('email', $validate['email'])->first()) {
            return response()->json([], 409);
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

        return response()->json();
    }
}
