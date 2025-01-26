<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\User\ApplicationService;

use Basic\ApplicationService\TransactionInterface;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;
use User\ApplicationService\Edit\Handle\EditUserHandleGenerator;
use User\ApplicationService\Edit\Handle\EditUserHandleResult;
use User\ApplicationService\Error\UserError;
use User\Domain\User\User;
use User\Domain\User\UserDomainServiceInterface;
use User\Domain\User\UserEmail;
use User\Domain\User\UserFactoryInterface;
use User\Domain\User\UserId;
use User\Domain\User\UserPermission;
use User\Domain\User\UserRepositoryInterface;
use User\UseCase\Edit\Handle\EditUserHandleRequest;
use User\UseCase\Edit\Handle\EditUserHandleResponse;

class EditUserHandleTest extends TestCase
{
    private UserDomainServiceInterface&MockObject $user_domain_service;

    private UserFactoryInterface&MockObject $user_factory;

    private UserRepositoryInterface&MockObject $user_repository;

    private TransactionInterface&MockObject $transaction;

    public function setUp(): void
    {
        parent::setUp();
        $this->user_domain_service = $this->createStub(UserDomainServiceInterface::class);
        $this->user_factory = $this->createStub(UserFactoryInterface::class);
        $this->user_repository = $this->createStub(UserRepositoryInterface::class);
        $this->transaction = $this->createStub(TransactionInterface::class);
    }

    public function testSuccess(): void
    {
        // 対象ユーザーは存在するか（ここでは存在する）
        $this->user_factory->method('createUserId')
            ->willReturn($this->createStub(UserId::class));

        $this->user_domain_service->method('existById')
            ->willReturn(true);

        // 新規アドレスは存在するか否か？（ここでは存在しない）
        $this->user_factory->method('createUserEmail')
            ->willReturn($this->createStub(UserEmail::class));

        $this->user_domain_service->method('existByNewEmail')
            ->willReturn(false);

        // 権限は存在するか？（ここでは存在する）
        $permission = $this->createStub(UserPermission::class);

        $permission->method('isExist')
            ->willReturn(true);

        // ユーザーを更新（エンティティ作成）
        $this->user_factory->method('create')
            ->willReturn($this->createStub(User::class));

        $app_request = new EditUserHandleRequest(
            str_repeat('a', 36),
            str_repeat('a', 50),
            'hogehoge@hogehoge.com',
            'admin'
        );

        $expect_app_response = new EditUserHandleResponse(
            EditUserHandleResult::success()
        );

        $interactor = new EditUserHandleGenerator(
            $this->user_domain_service,
            $this->user_factory,
            $this->user_repository,
            $this->transaction
        );

        $app_response = $interactor->handle($app_request);

        $this->assertEquals($expect_app_response, $app_response);
    }

    public function testUserError(): void
    {
        // 対象ユーザーは存在するか（ここでは存在する）
        $this->user_factory->method('createUserId')
            ->willReturn($this->createStub(UserId::class));

        $this->user_domain_service->method('existById')
            ->willReturn(false);

        $app_request = new EditUserHandleRequest(
            str_repeat('a', 36),
            str_repeat('a', 50),
            'hogehoge@hogehoge.com',
            'admin'
        );

        $expect_app_response = new EditUserHandleResponse(
            EditUserHandleResult::requestError(
                [
                    'request_error' => UserError::USER_NOT_EXIST,
                ]
            )
        );

        $interactor = new EditUserHandleGenerator(
            $this->user_domain_service,
            $this->user_factory,
            $this->user_repository,
            $this->transaction
        );

        $app_response = $interactor->handle($app_request);

        $this->assertEquals($expect_app_response, $app_response);
    }

    public function testEmailError(): void
    {
        $this->markTestIncomplete('This test has not been implemented yet.');

        // 対象ユーザーは存在するか（ここでは存在する）
        $this->user_factory->method('createUserId')
            ->willReturn($this->createStub(UserId::class));

        $this->user_domain_service->method('existById')
            ->willReturn(true);

        // 新規アドレスは存在するか否か？（ここでは存在する）
        $this->user_factory->method('createUserEmail')
            ->willReturn($this->createStub(UserEmail::class));

        $this->user_domain_service->method('existByNewEmail')
            ->willReturn(true);

        // 権限は存在するか？（ここでは存在する）
        $permission = $this->createStub(UserPermission::class);

        $permission->method('isExist')
            ->willReturn(true);

        $app_request = new EditUserHandleRequest(
            str_repeat('a', 36),
            str_repeat('a', 50),
            'hogehoge@hogehoge.com',
            'admin'
        );

        $expect_app_response = new EditUserHandleResponse(
            EditUserHandleResult::requestError(
                [
                    'email' => UserError::EMAIL_ALREADY_EXIST,
                ]
            )
        );

        $interactor = new EditUserHandleGenerator(
            $this->user_domain_service,
            $this->user_factory,
            $this->user_repository,
            $this->transaction
        );

        $app_response = $interactor->handle($app_request);

        $this->assertEquals($expect_app_response, $app_response);
    }

    public function testPermissionError(): void
    {
        $this->markTestIncomplete('This test has not been implemented yet.');

        // 対象ユーザーは存在するか（ここでは存在する）
        $this->user_factory->method('createUserId')
            ->willReturn($this->createStub(UserId::class));

        $this->user_domain_service->method('existById')
            ->willReturn(true);

        // 新規アドレスは存在するか否か？（ここでは存在しない）
        $this->user_factory->method('createUserEmail')
            ->willReturn($this->createStub(UserEmail::class));

        $this->user_domain_service->method('existByNewEmail')
            ->willReturn(false);

        // 権限は存在するか？（ここでは存しない）
        $permission = $this->createStub(UserPermission::class);

        $permission->method('isExist')
            ->willReturn(false);

        $app_request = new EditUserHandleRequest(
            str_repeat('a', 36),
            str_repeat('a', 50),
            'hogehoge@hogehoge.com',
            'admin'
        );

        $expect_app_response = new EditUserHandleResponse(
            EditUserHandleResult::requestError(
                [
                    'permission' => UserError::PERMISSION_NOT_EXIST,
                ]
            )
        );

        $interactor = new EditUserHandleGenerator(
            $this->user_domain_service,
            $this->user_factory,
            $this->user_repository,
            $this->transaction
        );

        $app_response = $interactor->handle($app_request);

        $this->assertEquals($expect_app_response, $app_response);
    }

    public function testhandleError(): void
    {
        // 対象ユーザーは存在するか（ここでは存在する）
        $this->user_factory->method('createUserId')
            ->willReturn($this->createStub(UserId::class));

        $this->user_domain_service->method('existById')
            ->willReturn(true);

        // 新規アドレスは存在するか否か？（ここでは存在しない）
        $this->user_factory->method('createUserEmail')
            ->willReturn($this->createStub(UserEmail::class));

        $this->user_domain_service->method('existByNewEmail')
            ->willReturn(false);

        // 権限は存在するか？（ここでは存在する）
        $permission = $this->createStub(UserPermission::class);

        $permission->method('isExist')
            ->willReturn(true);

        // ユーザーを更新（エンティティ作成）
        $this->user_factory->method('create')
            ->willReturn($this->createStub(User::class));

        $this->user_repository->method('update')
            ->willThrowException(new Exception('error'));

        $app_request = new EditUserHandleRequest(
            str_repeat('a', 36),
            str_repeat('a', 50),
            'hogehoge@hogehoge.com',
            'admin'
        );

        $expect_app_response = new EditUserHandleResponse(
            EditUserHandleResult::handleError(
                [
                    'handle_error' => 'error',
                ]
            )
        );

        $interactor = new EditUserHandleGenerator(
            $this->user_domain_service,
            $this->user_factory,
            $this->user_repository,
            $this->transaction
        );

        $app_response = $interactor->handle($app_request);

        $this->assertEquals($expect_app_response, $app_response);
    }
}
