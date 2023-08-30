<?php

namespace Slutsky\Library\Entity;

class Author
{
    private ?int $id = null;
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function update(string $name): void
    {
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
