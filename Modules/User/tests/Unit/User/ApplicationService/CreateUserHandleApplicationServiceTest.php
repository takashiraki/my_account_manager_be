<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\User\ApplicationService;

use Basic\ApplicationService\RandomStringInterface;
use Basic\ApplicationService\TransactionInterface;
use Basic\ApplicationService\UuidInterface;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;
use User\ApplicationService\Create\Handle\CreateUserHandleApplicationService;
use USer\ApplicationService\Create\Handle\CreateUserHandleResult;
use User\ApplicationService\Error\UserError;
use User\Domain\User\User;
use User\Domain\User\UserDomainServiceInterface;
use User\Domain\User\UserEmail;
use User\Domain\User\UserFactoryInterface;
use User\Domain\User\UserRepositoryInterface;
use User\UseCase\Create\Handle\CreateUserHandleRequest;
use User\UseCase\Create\Handle\CreateUserHandleResponse;

class CreateUserHandleApplicationServiceTest extends TestCase
{
    private UserFactoryInterface&MockObject $user_factory;

    private UserDomainServiceInterface&MockObject $user_domain_service;

    private UserRepositoryInterface&MockObject $user_repository;

    private RandomStringInterface&MockObject $random_string;

    private UuidInterface&MockObject $uuid;

    private TransactionInterface&MockObject $transaction;

    public function setUp(): void
    {
        parent::setUp();

        $this->user_factory = $this->createStub(UserFactoryInterface::class);
        $this->user_domain_service = $this->createStub(UserDomainServiceInterface::class);
        $this->user_repository = $this->createStub(UserRepositoryInterface::class);
        $this->random_string = $this->createStub(RandomStringInterface::class);
        $this->uuid = $this->createStub(UuidInterface::class);
        $this->transaction = $this->createStub(TransactionInterface::class);
    }

    public function testSuccess(): void
    {
        $this->user_domain_service->method('existByEmail')->willReturn(false);

        $this->user_factory->method('createUserEmail')
            ->willReturn($this->createStub(UserEmail::class));

        $this->uuid->method('generate')->willReturn('hogehogehogehogehogehgoehogehogehoge');

        $this->user_factory->method('create')
            ->willReturn($this->createStub(User::class));

        $this->random_string->method('generate')->willReturn('hogehogehogehogehogehogehogehogehoge');

        $app_request = new CreateUserHandleRequest(
            'hogehgoe',
            'hogehoge@example.com',
            'admin'
        );

        $expect_app_response = new CreateUserHandleResponse(
            CreateUserHandleResult::success(
                user: $this->createStub(User::class)
            )
        );

        $interactor = new CreateUserHandleApplicationService(
            $this->user_factory,
            $this->user_domain_service,
            $this->user_repository,
            $this->random_string,
            $this->uuid,
            $this->transaction
        );

        $actual_app_response = $interactor->handle($app_request);

        $this->assertEquals($expect_app_response, $actual_app_response);
    }

    public function testEmailError(): void
    {
        $this->user_domain_service->method('existByEmail')->willReturn(true);

        $this->user_factory->method('createUserEmail')
            ->willReturn($this->createStub(UserEmail::class));

        $app_request = new CreateUserHandleRequest(
            'hogehgoe',
            'hogehoge@example.com',
            'admin'
        );

        $expect_app_response = new CreateUserHandleResponse(
            CreateUserHandleResult::requestError(
                request_error_messages:[
                    'email' => UserError::EMAIL_ALREADY_EXIST,
                ]
            )
        );

        $interactor = new CreateUserHandleApplicationService(
            $this->user_factory,
            $this->user_domain_service,
            $this->user_repository,
            $this->random_string,
            $this->uuid,
            $this->transaction
        );

        $actual_app_response = $interactor->handle($app_request);

        $this->assertEquals($expect_app_response, $actual_app_response);
    }

    public function testHandleError(): void
    {
        $this->user_domain_service->method('existByEmail')->willReturn(false);

        $this->user_factory->method('createUserEmail')
            ->willReturn($this->createStub(UserEmail::class));

        $this->uuid->method('generate')->willReturn('hogehogehogehogehogehgoehogehogehoge');

        $this->user_factory->method('create')
            ->willReturn($this->createStub(User::class));

        $this->random_string->method('generate')->willReturn('hogehogehogehogehogehogehogehogehoge');

        $this->user_repository->method('create')->willThrowException(new Exception('error'));

        $app_request = new CreateUserHandleRequest(
            'hogehgoe',
            'hogehoge@example.com',
            'admin'
        );

        $expect_app_response = new CreateUserHandleResponse(
            CreateUserHandleResult::handleError(
                handle_error_messages:[
                    'handle_error' => 'error',
                ]
            )
        );

        $interactor = new CreateUserHandleApplicationService(
            $this->user_factory,
            $this->user_domain_service,
            $this->user_repository,
            $this->random_string,
            $this->uuid,
            $this->transaction
        );

        $actual_app_response = $interactor->handle($app_request);

        $this->assertEquals($expect_app_response, $actual_app_response);
    }
}
