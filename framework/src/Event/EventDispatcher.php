<?php

namespace Queendev\PhpFramework\Event;

use Psr\EventDispatcher\EventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface
{
    private array $listeners = [];

    public function dispatch(object $event)
    {
        foreach ($this->getListenersForEvents($event) as $listener) {
            $listener($event);
        }
    }

    public function addListener(string $eventName, callable $listener): self
    {
        $this->listeners[$eventName][] = $listener;

        return $this;
    }

    public function getListenersForEvents(object $event): iterable
    {
        return $this->listeners[$event::class] ?? [];
    }
}