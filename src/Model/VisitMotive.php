<?php

declare(strict_types=1);

namespace Doctolib\Model;

class VisitMotive
{
    private int $id;

    private string $name;

    private int $organizationId;

    private Speciality $speciality;

    private bool $allowNewPatients;

    private ?int $refVisitMotiveId;

    private ?int $visitMotiveCategoryId;

    public function __construct(int $id, string $name, int $organizationId, Speciality $speciality, bool $allowNewPatients, ?int $refVisitMotiveId, ?int $visitMotiveCategoryId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->organizationId = $organizationId;
        $this->speciality = $speciality;
        $this->allowNewPatients = $allowNewPatients;
        $this->refVisitMotiveId = $refVisitMotiveId;
        $this->visitMotiveCategoryId = $visitMotiveCategoryId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOrganizationId(): int
    {
        return $this->organizationId;
    }

    public function getSpeciality(): Speciality
    {
        return $this->speciality;
    }

    public function isAllowNewPatients(): bool
    {
        return $this->allowNewPatients;
    }

    public function getRefVisitMotiveId(): ?int
    {
        return $this->refVisitMotiveId;
    }

    public function getVisitMotiveCategoryId(): ?int
    {
        return $this->visitMotiveCategoryId;
    }
}
