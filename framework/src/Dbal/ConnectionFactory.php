<?php

namespace Queendev\PhpFramework\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

class ConnectionFactory
{
    public function __construct(
        private readonly string $databaseUrl
    )
    {
    }

    /**
     * @throws Exception
     */
    public function create(): Connection
    {
        return DriverManager::getConnection([
            'url' => $this->databaseUrl
        ]);
    }
}