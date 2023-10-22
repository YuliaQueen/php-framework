<?php

namespace Queendev\PhpFramework\Console;

interface CommandInterface
{
    public function execute(array $parameters = []): int;
}