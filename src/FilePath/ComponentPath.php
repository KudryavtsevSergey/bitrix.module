<?php

declare(strict_types=1);

namespace Sun\BitrixModule\FilePath;

use Sun\BitrixModule\Command\ComposerInstallCommand;

class ComponentPath implements FilePathInterface
{
    public function __construct(
        private readonly string $name,
        private readonly bool $isComposerComponent = false,
    ) {
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
