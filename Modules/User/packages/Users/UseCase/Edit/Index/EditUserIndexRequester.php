<?php

declare(strict_types=1);

namespace User\UseCase\Edit\Index;

interface EditUserIndexRequester
{
    public function index(EditUserIndexRequest $app_request): EditUserIndexResponse;
}
