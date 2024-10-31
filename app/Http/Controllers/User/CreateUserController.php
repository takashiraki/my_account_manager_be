<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use User\ApplicationService\Create\CreateUserHandleService;

class CreateUserController extends Controller
{
    public function handle(
        Request $http_request,
        CreateUserHandleService $service
    ): JsonResponse {
        $validate = $http_request->validate(
            [
                'name' => ['required', 'string', 'between:1,20'],
                'email' => ['required', 'email:filter,dns', 'between:1,100'],
                'permission' => ['required', 'in:admin,employee,viewer', 'between:1,100'],
            ]
        );

        $service->handle(
            $validate['name'],
            $validate['email'],
            $validate['permission']
        );

        return response()->json();
    }
}
