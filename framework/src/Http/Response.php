<?php

namespace Queendev\PhpFramework\Http;

class Response
{
    /**
     * @param string $content
     * @param int $statusCode
     * @param array $headers
     */
    public function __construct(
        private string $content = '',
        private int    $statusCode = 200,
        private array  $headers = []
    )
    {
        http_response_code($this->statusCode);
    }

    /**
     * @return void
     */
    public function send()
    {
        echo $this->content;
    }

    /**
     * @param string $content
     * @return Response
     */
    public function setContent(string $content): Response
    {
        $this->content = $content;

        return $this;
    }
}