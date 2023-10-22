<?php

namespace Queendev\PhpFramework\Console;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Kernel
{
    public function __construct(
        private ContainerInterface $container,
        private Application        $application
    )
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws \ReflectionException
     * @throws NotFoundExceptionInterface|ConsoleException
     */
    public function handle(): int
    {
        $this->registerCommands();

        return $this->application->run();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \ReflectionException
     */
    private function registerCommands(): void
    {
        $commandFiles = new \DirectoryIterator(__DIR__ . '/Commands');
        $namespace = $this->container->get('console-command-namespace');

        foreach ($commandFiles as $file) {
            if (!$file->isFile()) {
                continue;
            }

            $command = $namespace . pathinfo($file, PATHINFO_FILENAME);

            if (is_subclass_of($command, CommandInterface::class)) {
                $name = (new \ReflectionClass($command))->getProperty('name')->getDefaultValue();
                $this->container->add(CommandPrefix::CONSOLE->value . $name, $command);
            }
        }
    }
}