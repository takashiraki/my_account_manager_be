<?php

declare(strict_types=1);

namespace Modules\User\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\User\Http\Requests\User\CreateUserRequest;
use User\UseCase\Create\Handle\CreateUserHandleRequest;
use User\UseCase\Create\Handle\CreateUserHandleRequester;

class CreateUserController extends Controller
{
    public function handle(
        CreateUserRequest $http_request,
        CreateUserHandleRequester $service
    ): JsonResponse {
        $app_request = new CreateUserHandleRequest(
            $http_request->input('name'),
            $http_request->input('email'),
            $http_request->input('permission')
        );

        $app_response = $service->handle($app_request);

        if ($app_response->result->iserror()) {
            $status = '';
            $message = [];

            if ($app_response->result->request_error_messages !== null) {
                $status = '422';
                $message = $app_response->result->request_error_messages;
            }

            if ($app_response->result->handle_error_messages !== null) {
                $status = '500';
                $message = $app_response->result->handle_error_messages;
            }

            return response()->json($message, $status);
        }

        return response()->json();
    }
}
