<?php

declare(strict_types=1);

namespace Sun\BitrixModule\Command;

class ChangeDirectoryCommand implements CommandInterface
{
    private string $directory;

    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    public function getCommand(): string
    {
        return sprintf('cd %s', $this->directory);
    }
}
