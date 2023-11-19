<?php

namespace App\Listeners;

use Queendev\PhpFramework\Dbal\Events\EntityPersist;

class HandleEntityListener
{
    public function __invoke(EntityPersist $event)
    {
        // TODO: Implement __invoke() method.
    }
}