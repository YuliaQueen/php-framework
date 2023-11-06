<?php

namespace Queendev\PhpFramework\Template;

use Queendev\PhpFramework\Session\SessionInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class TwigFactory
{
    public function __construct(
        private string           $viewsPath,
        private SessionInterface $session
    )
    {
    }

    public function create(): Environment
    {
        $loader = new FilesystemLoader($this->viewsPath);
        $twig = new Environment($loader, [
            'cache' => false,
            'debug' => true
        ]);

        $twig->addExtension(new DebugExtension());
        $twig->addFunction(new TwigFunction('session', [$this, 'getSession']));
        $twig->addFunction(new TwigFunction('uri', [$this, 'getUri']));
        $twig->addFunction(new TwigFunction('textTruncate', [$this, 'textTruncate']));
        $twig->addFunction(new TwigFunction('randomHexColor', [$this, 'randomHexColor']));

        return $twig;
    }

    public function getSession(): SessionInterface
    {
        return $this->session;
    }

    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function textTruncate(string $text, int $maxLength = 45): string
    {
        if (mb_strlen($text) > $maxLength) {
            $text = mb_strimwidth($text, 0, $maxLength, '...');
        }
        return $text;
    }

    function randomHexColor(): string{
        $hexColor = '#';

        for ($i = 0; $i < 6; $i++) {
            $hexColor .= dechex(mt_rand(0, 15));
        }

        return $hexColor;
    }
}