<?php

namespace Sun\BitrixModule\HighLoad;

use Sun\BitrixModule\Exception\InternalError;

class HighLoadTable implements BitrixPropertiesInterface
{
    private string $name;
    /**
     * @var HighLoadField[]
     */
    private array $fields;

    /**
     * @param string $name
     * @param HighLoadField[] $fields
     */
    public function __construct(string $name, array $fields)
    {
        if (!preg_match('~^\p{Lu}~u', $name)) {
            throw new InternalError(sprintf('The name %s of the highload block must start with a capital letter', $name));
        }
        if (!preg_match('/[A-Za-z0-9]+/', $name)) {
            throw new InternalError(sprintf('The name %s of the highload block must consist only of latin letters and numbers', $name));
        }
        $this->name = $name;
        $this->fields = $fields;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProperties(): array
    {
        return array_map(fn(HighLoadField $highLoadField): array => $highLoadField->getProperties(), $this->fields);
    }
}
