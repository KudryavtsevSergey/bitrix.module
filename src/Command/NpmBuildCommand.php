<?php

namespace Sun\BitrixModule\Command;

class NpmBuildCommand implements CommandInterface
{
    private const COMMAND = 'npm run build';

    public function getCommand(): string
    {
        return self::COMMAND;
    }
}
