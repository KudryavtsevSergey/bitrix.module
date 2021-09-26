<?php

namespace Sun\BitrixModule\FilePath;

use Sun\BitrixModule\Command\CommandInterface;

interface FilePathInterface
{
    public function getName(): string;

    /**
     * @return CommandInterface[]
     */
    public function getCommands(): array;
}
