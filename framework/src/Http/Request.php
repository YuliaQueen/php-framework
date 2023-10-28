<?php

namespace Queendev\PhpFramework\Http;

class Request
{
    /**
     * @param array $getParams
     * @param array $postData
     * @param array $files
     * @param array $server
     * @param array $cookies
     */
    public function __construct(
        private readonly array $getParams,
        private readonly array $postData,
        private readonly array $files,
        private readonly array $server,
        private readonly array $cookies
    )
    {
    }

    /**
     * @return static
     */
    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_FILES, $_SERVER, $_COOKIE);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    /**
     * @return array
     */
    public function getGetParams(): array
    {
        return $this->getParams;
    }

    /**
     * @return array
     */
    public function getPostData(): array
    {
        return $this->postData;
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @return array
     */
    public function getServer(): array
    {
        return $this->server;
    }

    /**
     * @return array
     */
    public function getCookies(): array
    {
        return $this->cookies;
    }
}