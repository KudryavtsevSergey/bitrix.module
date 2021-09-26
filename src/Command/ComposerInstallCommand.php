<?php

namespace Sun\BitrixModule\Command;

class ComposerInstallCommand implements CommandInterface
{
    private const COMMAND = 'composer install && composer dump-autoload';

    public function getCommand(): string
    {
        return self::COMMAND;
    }
}
