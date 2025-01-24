<?php

declare(strict_types=1);

namespace User\StubGenerator\Edit\Index;

use User\ApplicationService\Edit\Index\EditUserIndexResult;
use User\Domain\User\PasswordHasherInterface;
use User\Domain\User\UserFactoryInterface;
use User\UseCase\Edit\Index\EditUserIndexRequest;
use User\UseCase\Edit\Index\EditUserIndexRequester;
use User\UseCase\Edit\Index\EditUserIndexResponse;

class StubEditUserIndexGenerator implements EditUserIndexRequester
{
    public function __construct(
        private UserFactoryInterface $user_factory,
        private PasswordHasherInterface $password_hasher
    ) {
    }

    public function index(EditUserIndexRequest $app_request): EditUserIndexResponse
    {
        return new EditUserIndexResponse(
            EditUserIndexResult::success(),
            $this->user_factory->create(
                $app_request->id,
                str_repeat('a', 50),
                'hogehoge@hogehoge.com',
                'admin',
                $this->password_hasher->hash('password')
            )
        );
    }
}
