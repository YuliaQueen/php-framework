<?php

namespace Queendev\PhpFramework\Dbal\Events;

use Queendev\PhpFramework\Dbal\Entity;
use Queendev\PhpFramework\Event\Event;

class EntityPersist extends Event
{
    public function __construct(
        private Entity $entity
    )
    {
    }

    public function getEntity(): Entity
    {
        return $this->entity;
    }
}