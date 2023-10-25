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
        $connection =  DriverManager::getConnection([
            'url' => $this->databaseUrl
        ]);

        $connection->setAutoCommit(false);

        return $connection;
    }
}