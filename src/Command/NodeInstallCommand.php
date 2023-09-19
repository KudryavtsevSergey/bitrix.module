<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Command;

class NodeInstallCommand implements CommandInterface
{
    private const COMMAND = 'npm ci';

    public function getCommand(): string
    {
        return self::COMMAND;
    }
}
