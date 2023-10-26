<?php

declare(strict_types=1);

namespace Sun\BitrixModule;

class Version
{
    public function __construct(
        private readonly string $version,
        private readonly string $date,
    ) {
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}
