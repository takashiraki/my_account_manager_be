<?php

declare(strict_types=1);

namespace User\UseCase\Edit\Handle;

interface EditUserHandleRequester
{
    public function handle(EditUserHandleRequest $app_request): EditUserHandleResponse;
}
