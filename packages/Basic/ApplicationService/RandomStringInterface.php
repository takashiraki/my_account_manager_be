<?php

declare(strict_types=1);

namespace Basic\ApplicationService;

interface RandomStringInterface
{
    public function generate(int $length): string;
}
