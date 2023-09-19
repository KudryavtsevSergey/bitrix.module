<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Command;

class ComposerInstallCommand implements CommandInterface
{
    private const COMMAND = 'composer install && composer dump-autoload';

    public function getCommand(): string
    {
        return self::COMMAND;
    }
}
