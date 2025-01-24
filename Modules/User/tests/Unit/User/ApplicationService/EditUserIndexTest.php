<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\User\ApplicationService;

use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;
use User\ApplicationService\Edit\Index\EditUserIndexGenerator;
use User\ApplicationService\Edit\Index\EditUserIndexResult;
use User\ApplicationService\Error\UserError;
use User\Domain\User\User;
use User\Domain\User\UserDomainServiceInterface;
use User\Domain\User\UserFactoryInterface;
use User\Domain\User\UserId;
use User\Domain\User\UserRepositoryInterface;
use User\UseCase\Edit\Index\EditUserIndexRequest;
use User\UseCase\Edit\Index\EditUserIndexResponse;

class EditUserIndexTest extends TestCase
{
    private UserDomainServiceInterface&MockObject $user_domain_service;

    private UserFactoryInterface&MockObject $user_factory;

    private UserRepositoryInterface&MockObject $user_repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->user_domain_service = $this->createStub(UserDomainServiceInterface::class);
        $this->user_factory = $this->createStub(UserFactoryInterface::class);
        $this->user_repository = $this->createStub(UserRepositoryInterface::class);
    }

    /**
     * 晴れの日：ユーザーが存在する場合
     *
     * @return void
     */
    public function testSuccess(): void
    {
        // 対象ユーザーがいるかの確認
        $this->user_factory->method('createUserId')
            ->willReturn($this->createStub(UserId::class));

        $this->user_domain_service->method('existById')
            ->willReturn(true);

        // ユーザー情報の取得
        $this->user_repository->method('findById')
            ->willReturn($this->createStub(User::class));

        // DTO
        $app_request = new EditUserIndexRequest(
            str_repeat('a', 36)
        );

        $expect_app_response = new EditUserIndexResponse(
            EditUserIndexResult::success(),
            $this->createStub(User::class)
        );

        $interactor = new EditUserIndexGenerator(
            $this->user_domain_service,
            $this->user_factory,
            $this->user_repository
        );

        $app_response = $interactor->index($app_request);

        $this->assertEquals($expect_app_response, $app_response);
    }

    public function testNotExistUser(): void
    {
        // 対象ユーザーがいるかの確認
        $this->user_factory->method('createUserId')
            ->willReturn($this->createStub(UserId::class));

        $this->user_domain_service->method('existById')
            ->willReturn(false);

        // DTO
        $app_request = new EditUserIndexRequest(
            str_repeat('a', 36)
        );

        $expect_app_response = new EditUserIndexResponse(
            EditUserIndexResult::requestError(
                [
                    'request_error' => UserError::USER_NOT_EXIST,
                ]
            ),
            null
        );

        $interactor = new EditUserIndexGenerator(
            $this->user_domain_service,
            $this->user_factory,
            $this->user_repository
        );

        $app_response = $interactor->index($app_request);

        $this->assertEquals($expect_app_response, $app_response);
    }
}
