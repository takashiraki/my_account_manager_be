<?php

declare(strict_types=1);

namespace User\ApplicationService\Create\Handle;

use Basic\ApplicationService\RandomStringInterface;
use Basic\ApplicationService\TransactionInterface;
use Basic\ApplicationService\UuidInterface;
use Exception;
use USer\ApplicationService\Create\Handle\CreateUserHandleResult;
use User\ApplicationService\Error\UserError;
use User\Domain\User\PasswordHasherInterface;
use User\Domain\User\UserDomainServiceInterface;
use User\Domain\User\UserFactoryInterface;
use User\Domain\User\UserRepositoryInterface;
use User\UseCase\Create\Handle\CreateUserHandleRequest;
use User\UseCase\Create\Handle\CreateUserHandleRequester;
use User\UseCase\Create\Handle\CreateUserHandleResponse;

class CreateUserHandleApplicationService implements CreateUserHandleRequester
{
    private const PASSWORD_LENGTH = 8;

    public function __construct(
        private UserFactoryInterface $user_factory,
        private UserDomainServiceInterface $user_domain_service,
        private UserRepositoryInterface $user_repository,
        private PasswordHasherInterface $password_hasher,
        private RandomStringInterface $random_string,
        private UuidInterface $uuid,
        private TransactionInterface $transaction
    ) {
    }

    public function handle(CreateUserHandleRequest $app_request): CreateUserHandleResponse
    {
        if ($this->user_domain_service->existByEmail(
            $this->user_factory->createUserEmail($app_request->email)
        )) {
            return new CreateUserHandleResponse(
                CreateUserHandleResult::requestError(
                    request_error_messages:[
                        'email' => UserError::EMAIL_ALREADY_EXIST,
                    ]
                )
            );
        }

        $this->transaction->begin();

        $raw_password = $this->random_string->generate(self::PASSWORD_LENGTH);

        $user = $this->user_factory->create(
            $this->uuid->generate(),
            $app_request->name,
            $app_request->email,
            $app_request->permission,
            $this->password_hasher->hash($raw_password)
        );

        try {
            $this->user_repository->create($user);

            $this->transaction->commit();
        } catch (Exception $exception) {
            $this->transaction->rollback();

            return new CreateUserHandleResponse(
                CreateUserHandleResult::handleError(
                    handle_error_messages:[
                        'handle_error' => $exception->getMessage(),
                    ]
                )
            );
        }

        return new CreateUserHandleResponse(
            CreateUserHandleResult::success($user)
        );
    }
}
