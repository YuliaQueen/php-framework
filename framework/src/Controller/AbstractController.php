<?php

namespace Queendev\PhpFramework\Controller;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Queendev\PhpFramework\Http\Response;

abstract class AbstractController
{
    protected ?ContainerInterface $container = null;

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

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
}