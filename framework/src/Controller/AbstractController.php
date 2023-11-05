<?php

namespace Queendev\PhpFramework\Controller;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Queendev\PhpFramework\Http\Request;
use Queendev\PhpFramework\Http\Response;
use Queendev\PhpFramework\Session\SessionInterface;

abstract class AbstractController
{
    protected ?ContainerInterface $container = null;
    protected Request $request;
    protected SessionInterface $session;

    /**
     * @param string $view
     * @param array $params
     * @param Response|null $response
     * @return Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function render(string $view, array $params = [], Response $response = null): Response
    {
        $response ??= new Response();

        $view = sprintf('%s.html.twig', $view);

        $content = $this->container->get('twig')->render($view, $params);

        return $response->setContent($content);
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    /**
     * @param SessionInterface $session
     * @return void
     */
    public function setSession(SessionInterface $session): void
    {
        $this->session = $session;
    }
}