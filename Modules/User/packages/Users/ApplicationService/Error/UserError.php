<?php

declare(strict_types=1);

namespace User\ApplicationService\Error;

class UserError
{
    public const USER_NOT_EXIST = 'ユーザーが存在しません。';
    
    public const EMAIL_ALREADY_EXIST = 'このメールアドレスはすでに登録されています。';
}
