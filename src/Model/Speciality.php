<?php

declare(strict_types=1);

namespace Doctolib\Model;

class Speciality
{
    private int $id;

    private string $name;

    private ?string $slug;

    private ?string $kind;

    public function __construct(int $id, string $name, ?string $slug = null, ?string $kind = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->kind = $kind;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getKind(): ?string
    {
        return $this->kind;
    }
}
