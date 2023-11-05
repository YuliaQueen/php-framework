<?php

use Doctrine\DBAL\Connection;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Queendev\PhpFramework\Console\Application;
use Queendev\PhpFramework\Console\CommandPrefix;
use Queendev\PhpFramework\Console\Commands\MigrateCommand;
use Queendev\PhpFramework\Console\Kernel as ConsoleKernel;
use Queendev\PhpFramework\Controller\AbstractController;
use Queendev\PhpFramework\Dbal\ConnectionFactory;
use Queendev\PhpFramework\Http\Kernel;
use Queendev\PhpFramework\Routing\Router;
use Queendev\PhpFramework\Routing\RouterInterface;
use Queendev\PhpFramework\Session\Session;
use Queendev\PhpFramework\Session\SessionInterface;
use Queendev\PhpFramework\Template\TwigFactory;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;

$dotenv = new Dotenv();
$dotenv->load(BASE_PATH . '/.env');

// Application parameters
$routes = include BASE_PATH . '/routes/web.php';
$appEnv = $_ENV['APP_ENV'] ?? 'dev';
$viewsPath = BASE_PATH . '/views';
$databaseUrl = $_ENV['DATABASE_URL'] ?? '';

// Application services
$container = new Container();
$container->delegate(new ReflectionContainer(true));

$container->add('APP_ENV', new StringArgument($appEnv));

$container->add(RouterInterface::class, Router::class);
$container->extend(RouterInterface::class)->addMethodCall('registerRoutes', [new ArrayArgument($routes)]);

$container->add(Kernel::class)
    ->addArgument(RouterInterface::class)
    ->addArgument($container);

$container->add(SessionInterface::class, Session::class);

$container->add('twig-factory', TwigFactory::class)
    ->addArguments([
        new StringArgument($viewsPath),
        SessionInterface::class
    ]);

$container->addShared('twig', function () use ($container): Environment {
    return $container->get('twig-factory')->create();
});

$container->inflector(AbstractController::class)
    ->invokeMethod('setContainer', [$container])
    ->invokeMethod('setSession', [$container->get(SessionInterface::class)]);

$container->add(ConnectionFactory::class)
    ->addArgument(new StringArgument($databaseUrl));

$container->addShared(Connection::class, function () use ($container): Connection {
    return $container->get(ConnectionFactory::class)->create();
});

/** ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

// Console services

$container->add(Application::class)
    ->addArgument($container);

$container->add(ConsoleKernel::class)
    ->addArgument($container)
    ->addArgument(Application::class);

$container->add('console-command-namespace', new StringArgument('Queendev\\PhpFramework\\Console\\Commands\\'));

$container->add(CommandPrefix::CONSOLE->value . 'migrate', MigrateCommand::class)
    ->addArgument(Connection::class)
    ->addArgument(new StringArgument(BASE_PATH . '/database/migrations'));

return $container;