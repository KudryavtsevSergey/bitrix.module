<?php

namespace Sun\BitrixModule\FilePath;

use Sun\BitrixModule\Command\ComposerInstallCommand;

class ComponentPath implements FilePathInterface
{
    private string $name;
    private bool $isComposerComponent;

    public function __construct(
        string $name,
        bool $isComposerComponent = false
    ) {
        $this->name = $name;
        $this->isComposerComponent = $isComposerComponent;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCommands(): array
    {
        return $this->isComposerComponent ? [new ComposerInstallCommand()] : [];
    }
}
