<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Utils;

use Sun\BitrixModule\Command\CommandInterface;

class CommandGenerator
{
    public function __construct(
        private array $commands,
    ) {
    }

    public function generate(): ?string
    {
        $commands = array_filter($this->commands);
        if (empty($commands)) {
            return null;
        }
        $commands = array_map(static function (array $installerCommands): string {
            $installerCommands = array_map(static function (array $commands): string {
                $commands = array_map(static fn(
                    CommandInterface $command
                ): string => $command->getCommand(), $commands);

                return implode(" \\\n&& ", $commands);
            }, $installerCommands);

            return implode(" \\\n\\\n&& ", $installerCommands);
        }, $commands);

        return implode(" \\\n\\\n\\\n&& ", $commands);
    }
}
