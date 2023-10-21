<?php

namespace Queendev\PhpFramework\Console;

class Kernel
{
    public function handle(): int
    {
        echo 'Hello from console';
        return 0;
    }
}