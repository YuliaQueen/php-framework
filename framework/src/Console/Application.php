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

        $args = array_slice($argv, 2);
        $options = $this->parseOptions($args);

        return $command->execute($options);
    }

    /**
     * @param $args
     * @return array
     */
    private function parseOptions($args): array
    {
        $options = [];
        foreach ($args as $arg) {
            if (str_starts_with($arg, '--')) {
                $option = explode('=', substr($arg, 2));
                $options[$option[0]] = $option[1] ?? true;
            }
        }

        return $options;
    }
}