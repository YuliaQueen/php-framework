<?php

namespace App\Listeners;

use Queendev\PhpFramework\Http\Events\ResponseEvent;

class ContentLengthListener
{
    const X_CONTENT_LENGTH = 'X-Content-Length';

    public function __invoke(ResponseEvent $event)
    {
        $response = $event->getResponse();

        if (!array_key_exists(self::X_CONTENT_LENGTH, $response->getHeaders())) {
            $response->setHeader(self::X_CONTENT_LENGTH, strlen($response->getContent()));
        }
    }
}