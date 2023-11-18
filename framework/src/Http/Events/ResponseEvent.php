<?php

namespace Queendev\PhpFramework\Http\Events;

use Queendev\PhpFramework\Event\Event;
use Queendev\PhpFramework\Http\Request;
use Queendev\PhpFramework\Http\Response;

class ResponseEvent extends Event
{
    public function __construct(
        private Request  $request,
        private Response $response
    )
    {
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}