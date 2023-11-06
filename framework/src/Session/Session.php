<?php

namespace Queendev\PhpFramework\Session;

class Session implements SessionInterface
{
    private const FLASH_KEY = 'flash';

    public function start(): void
    {
        session_start();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function getFlash(string $type): array
    {
        $flash = $this->getFlashByKey();
        if (isset($flash[$type])) {
            $messages = $flash[$type];
            unset($flash[$type]);
            $this->set(self::FLASH_KEY, $flash);
            return $messages;
        }

        return [];
    }

    public function setFlash(string $type, mixed $value): void
    {
        $flash = $this->getFlashByKey();
        $flash[$type][] = $value;
        $this->set(self::FLASH_KEY, $flash);
    }

    public function hasFlash(string $type): bool
    {
        $flash = $this->getFlashByKey();
        return isset($flash[$type]);
    }

    public function clearFlash(string $type): void
    {
        $flash = $this->getFlashByKey();
        unset($flash[$type]);
        $this->set(self::FLASH_KEY, $flash);
    }

    /**
     * @return mixed
     */
    private function getFlashByKey(): mixed
    {
        return $this->get(self::FLASH_KEY, []);
    }
}