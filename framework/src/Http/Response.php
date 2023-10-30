<?php

namespace Queendev\PhpFramework\Http;

class Response
{
    const CODE_REDIRECT = 302;
    const CODE_SUCCESS = 200;

    /**
     * @param string $content
     * @param int $statusCode
     * @param array $headers
     */
    public function __construct(
        private string $content = '',
        private int    $statusCode = self::CODE_SUCCESS,
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

    public function getHeader(string $string): string
    {
        return $this->headers[$string];
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}