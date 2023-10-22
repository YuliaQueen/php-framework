<?php

namespace Queendev\PhpFramework\Console;

use Psr\Container\ContainerInterface;

class Application
{
    public function __construct(
        private ContainerInterface $container
    )
    {
    }

    /**
     * @throws ConsoleException
     */
    public function run(): int
    {
        $argv = $_SERVER['argv'];

        $commandName = $argv[1] ?? null;

        if (!$commandName) {
            throw new ConsoleException('No command provided');
        }

        /** @var CommandInterface $command */
        $command = $this->container->get(CommandPrefix::CONSOLE->value . $commandName);

        return $command->execute();
    }
}