<?php

namespace Sun\BitrixModule\FilePath;

use Sun\BitrixModule\Command\NodeInstallCommand;
use Sun\BitrixModule\Command\NpmBuildCommand;

class NpmPath implements FilePathInterface
{
    public function __construct(
        private string $name,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCommands(): array
    {
        return [
            new NodeInstallCommand(),
            new NpmBuildCommand(),
        ];
    }
}
