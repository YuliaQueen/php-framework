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

        return $twig;
    }

    public function getSession(): SessionInterface
    {
        return $this->session;
    }

    public function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }
}