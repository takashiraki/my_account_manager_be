<?php

declare(strict_types=1);

namespace Basic\ApplicationService;

interface UuidInterface
{
    public function generate(): string;
}
