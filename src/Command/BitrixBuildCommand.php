<?php

namespace Sun\BitrixModule\Command;

class BitrixBuildCommand implements CommandInterface
{
    private const COMMAND = 'bitrix build';

    public function getCommand(): string
    {
        return self::COMMAND;
    }
}
