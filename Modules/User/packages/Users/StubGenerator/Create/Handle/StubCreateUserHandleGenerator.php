<?php

declare(strict_types=1);

namespace User\StubGenerator\Create\Handle;

use USer\ApplicationService\Create\Handle\CreateUserHandleResult;
use User\Domain\User\User;
use User\Domain\User\UserEmail;
use User\Domain\User\UserId;
use User\Domain\User\UserName;
use User\Domain\User\UserPermission;
use User\UseCase\Create\Handle\CreateUserHandleRequest;
use User\UseCase\Create\Handle\CreateUserHandleRequester;
use User\UseCase\Create\Handle\CreateUserHandleResponse;

class StubCreateUserHandleGenerator implements CreateUserHandleRequester
{
    public function handle(CreateUserHandleRequest $request): CreateUserHandleResponse
    {
        return new CreateUserHandleResponse(
            CreateUserHandleResult::success(
                new User(
                    new UserId('hogehogehogehogehogehogehogehogehoge'),
                    new UserName('fugafuga'),
                    new UserEmail('hogehgoe@example.com'),
                    new UserPermission('admin')
                )
            )
        );
    }
}
