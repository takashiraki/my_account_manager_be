<?php

declare(strict_types=1);

namespace Tests\Unit\User\ApplicationService;

use Basic\ApplicationService\RandomStringInterface;
use Basic\ApplicationService\TransactionInterface;
use Basic\ApplicationService\UuidInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use User\ApplicationService\Create\Handle\CreateUserHandleApplicationService;
use User\ApplicationService\Error\UserError;
use User\Domain\User\HashedPassword;
use User\Domain\User\PasswordHasherInterface;
use User\Domain\User\User;
use User\Domain\User\UserDomainServiceInterface;
use User\Domain\User\UserEmail;
use User\Domain\User\UserFactoryInterface;
use User\Domain\User\UserRepositoryInterface;
use User\UseCase\Create\Handle\CreateUserHandleRequest;
use User\UseCase\Create\Handle\CreateUserHandleResponse;

class CreateUserHandleApplicationServiceTest extends TestCase
{
    private UserFactoryInterface $user_factory;

    private UserDomainServiceInterface $user_domain_service;

    private UserRepositoryInterface $user_repository;

    private PasswordHasherInterface $password_hasher;

    private RandomStringInterface $random_string;

    private UuidInterface $uuid;

    private TransactionInterface $transaction;

    public function setUp(): void
    {
        parent::setUp();

        $this->user_factory = $this->createStub(UserFactoryInterface::class);
        $this->user_domain_service = $this->createStub(UserDomainServiceInterface::class);
        $this->user_repository = $this->createStub(UserRepositoryInterface::class);
        $this->password_hasher = $this->createStub(PasswordHasherInterface::class);
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

        $this->password_hasher->method('hash')->willReturn(
            $this->createStub(HashedPassword::class)
        );

        $app_request = new CreateUserHandleRequest(
            'hogehgoe',
            'hogehoge@example.com',
            'admin'
        );

        $expect_app_response = new CreateUserHandleResponse();

        $interactor = new CreateUserHandleApplicationService(
            $this->user_factory,
            $this->user_domain_service,
            $this->user_repository,
            $this->password_hasher,
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
            request_error_messages:[
                'email' => UserError::EMAIL_ALREADY_EXIST,
            ]
        );

        $interactor = new CreateUserHandleApplicationService(
            $this->user_factory,
            $this->user_domain_service,
            $this->user_repository,
            $this->password_hasher,
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

        $this->password_hasher->method('hash')->willReturn(
            $this->createStub(HashedPassword::class)
        );

        $this->user_repository->method('create')->willThrowException(new Exception('error'));

        $app_request = new CreateUserHandleRequest(
            'hogehgoe',
            'hogehoge@example.com',
            'admin'
        );

        $expect_app_response = new CreateUserHandleResponse(
            handle_error_messages:[
                'handle_error' => 'error',
            ]
        );

        $interactor = new CreateUserHandleApplicationService(
            $this->user_factory,
            $this->user_domain_service,
            $this->user_repository,
            $this->password_hasher,
            $this->random_string,
            $this->uuid,
            $this->transaction
        );

        $actual_app_response = $interactor->handle($app_request);

        $this->assertEquals($expect_app_response, $actual_app_response);
    }
}
