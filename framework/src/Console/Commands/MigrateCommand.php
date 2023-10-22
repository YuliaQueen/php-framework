<?php

namespace Queendev\PhpFramework\Console\Commands;

use Queendev\PhpFramework\Console\CommandInterface;

class MigrateCommand implements CommandInterface
{
    private string $name = 'migrate';

    public function execute(array $parameters = []): int
    {
        echo "migrate executed"; // TODO: to realize execute() method.
        return 0;
    }
}