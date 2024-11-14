<?php

declare(strict_types=1);

namespace Basic\ApplicationService;

interface TransactionInterface
{
    public function begin(): void;

    public function commit(): void;

    public function rollback(): void;
}
