<?php

namespace Queendev\PhpFramework\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Queendev\PhpFramework\Dbal\Events\EntityPersist;
use Queendev\PhpFramework\Event\EventDispatcher;

class EntityService
{
    public function __construct(
        private Connection $connection,
        private EventDispatcher $eventDispatcher
    )
    {
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }

    /**
     * @throws Exception
     */
    public function save(Entity $entity): int
    {
        $lastInsertId = $this->connection->lastInsertId();
        $entity->setId($lastInsertId);
        
        $this->eventDispatcher->dispatch(new EntityPersist($entity));

        return $lastInsertId;
    }
}