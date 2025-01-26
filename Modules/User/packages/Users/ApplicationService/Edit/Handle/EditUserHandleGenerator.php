<?php

declare(strict_types=1);

namespace User\ApplicationService\Edit\Handle;

use Basic\ApplicationService\TransactionInterface;
use Exception;
use User\ApplicationService\Error\UserError;
use User\Domain\User\UserDomainServiceInterface;
use User\Domain\User\UserFactoryInterface;
use User\Domain\User\UserPermission;
use User\Domain\User\UserRepositoryInterface;
use User\UseCase\Edit\Handle\EditUserHandleRequest;
use User\UseCase\Edit\Handle\EditUserHandleRequester;
use User\UseCase\Edit\Handle\EditUserHandleResponse;

class EditUserHandleGenerator implements EditUserHandleRequester
{
    public function __construct(
        private UserDomainServiceInterface $user_domain_service,
        private UserFactoryInterface $user_factory,
        private UserRepositoryInterface $user_repository,
        private TransactionInterface $transaction
    ) {
    }

    public function handle(EditUserHandleRequest $app_request): EditUserHandleResponse
    {
        $user_id = $this->user_factory->createUserId($app_request->id);
        if (! $this->user_domain_service->existById($user_id)) {
            return new EditUserHandleResponse(
                EditUserHandleResult::requestError(
                    [
                        'request_error' => UserError::USER_NOT_EXIST,
                    ]
                )
            );
        }

        $user_email = $this->user_factory->createUserEmail($app_request->email);
        if ($this->user_domain_service->existByNewEmail($user_email)) {
            return new EditUserHandleResponse(
                EditUserHandleResult::requestError(['email' => UserError::EMAIL_ALREADY_EXIST])
            );
        }

        if (! UserPermission::isExist($app_request->permission)) {
            return new EditUserHandleResponse(
                EditUserHandleResult::requestError(['permission' => UserError::PERMISSION_NOT_EXIST])
            );
        }
        
        $this->transaction->begin();
        try {
            $this->user_repository->update(
                $this->user_factory->create(
                    $app_request->id,
                    $app_request->name,
                    $app_request->email,
                    $app_request->permission
                )
            );
            $this->transaction->commit();
        } catch (Exception $e) {
            $this->transaction->rollback();
            return new EditUserHandleResponse(
                EditUserHandleResult::handleError(['handle_error' => $e->getMessage()])
            );
        }

        return new EditUserHandleResponse(
            EditUserHandleResult::success()
        );
    }
}
