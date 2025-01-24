<?php

declare(strict_types=1);

namespace User\ApplicationService\Edit\Index;

use User\ApplicationService\Error\UserError;
use User\Domain\User\UserDomainServiceInterface;
use User\Domain\User\UserFactoryInterface;
use User\Domain\User\UserRepositoryInterface;
use User\UseCase\Edit\Index\EditUserIndexRequest;
use User\UseCase\Edit\Index\EditUserIndexRequester;
use User\UseCase\Edit\Index\EditUserIndexResponse;

class EditUserIndexGenerator implements EditUserIndexRequester
{
    public function __construct(
        private UserDomainServiceInterface $user_domain_service,
        private UserFactoryInterface $user_factory,
        private UserRepositoryInterface $user_repository
    ) {
    }

    public function index(EditUserIndexRequest $app_request): EditUserIndexResponse
    {
        $user_id = $this->user_factory->createUserId($app_request->id);

        if (! $this->user_domain_service->existById($user_id)) {
            return new EditUserIndexResponse(
                EditUserIndexResult::requestError(
                    [
                        'request_error' => UserError::USER_NOT_EXIST,
                    ]
                ),
                null
            );
        }

        return new EditUserIndexResponse(
            EditUserIndexResult::success(),
            $this->user_repository->findById($user_id)
        );
    }
}
