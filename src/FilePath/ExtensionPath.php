<?php

namespace Sun\BitrixModule\FilePath;

use Sun\BitrixModule\Command\BitrixBuildCommand;
use Sun\BitrixModule\Command\NodeInstallCommand;

class ExtensionPath implements FilePathInterface
{
    private string $name;
    private bool $isNodeExtension;

    public function __construct(
        string $name,
        bool $isNodeExtension = false
    ) {
        $this->name = $name;
        $this->isNodeExtension = $isNodeExtension;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCommands(): array
    {
        $bitrixCommand = new BitrixBuildCommand();
        return $this->isNodeExtension ? [
            new NodeInstallCommand(),
            $bitrixCommand,
        ]: [$bitrixCommand];
    }
}
