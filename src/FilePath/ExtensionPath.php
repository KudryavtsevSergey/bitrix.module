<?php

declare(strict_types=1);

namespace Sun\BitrixModule\FilePath;

use Sun\BitrixModule\Command\BitrixBuildCommand;
use Sun\BitrixModule\Command\NodeInstallCommand;

class ExtensionPath implements FilePathInterface
{
    public function __construct(
        private readonly string $name,
        private readonly bool $isNodeExtension = false,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCommands(): array
    {
        return array_merge(
            $this->isNodeExtension ? [new NodeInstallCommand()]: [],
            [new BitrixBuildCommand()]
        );
    }
}
