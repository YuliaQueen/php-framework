<?php

namespace App\Providers;

use App\Listeners\ContentLengthListener;
use App\Listeners\HandleEntityListener;
use Queendev\PhpFramework\Dbal\Events\EntityPersist;
use Queendev\PhpFramework\Event\EventDispatcher;
use Queendev\PhpFramework\Http\Events\ResponseEvent;
use Queendev\PhpFramework\Providers\ServiceProviderInterface;

class EventServiceProvider implements ServiceProviderInterface
{
    private array $listen = [
        ResponseEvent::class => [
            ContentLengthListener::class
        ],
        EntityPersist::class => [
            HandleEntityListener::class
        ]

    ];

    public function __construct(
        private EventDispatcher $eventDispatcher
    )
    {
    }

    public function register(): void
    {
        foreach ($this->listen as $event => $listeners) {
            foreach (array_unique($listeners) as $listener) {
                $this->eventDispatcher->addListener($event, new $listener);
            }
        }
    }
}