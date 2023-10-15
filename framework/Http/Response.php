<?php

namespace Queendev\PhpFramework\Http;

class Response
{
    /**
     * @param string $content
     * @param int $status
     * @param array $headers
     */
    public function __construct(
        private string $content,
        private int    $status = 200,
        private array  $headers = []
    )
    {
    }

    /**
     * @return void
     */
    public function send()
    {
        echo $this->content;
    }
}