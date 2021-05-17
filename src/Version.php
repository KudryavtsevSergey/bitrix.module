<?php

namespace Sun\BitrixModule;

class Version
{
    private string $version;
    private string $date;

    public function __construct(string $version, string $date)
    {
        $this->version = $version;
        $this->date = $date;
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
