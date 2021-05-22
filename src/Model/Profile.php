<?php

declare(strict_types=1);

namespace Doctolib\Model;

class Profile
{
    private int $id;

    private string $nameWithTitle;

    private ?string $city;

    private ?string $link;

    private ?int $profileId;

    private ?string $address;

    private ?string $zipcode;

    private ?string $lastName;

    private ?Point $position;

    private ?string $firstName;

    private ?Speciality $speciality;

    /**
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(int $id, string $nameWithTitle, ?string $city = null, ?string $link = null, ?int $profileId = null, ?string $address = null, ?string $zipcode = null, ?string $lastName = null, ?Point $position = null, ?string $firstName = null, ?Speciality $speciality = null)
    {
        $this->id = $id;
        $this->nameWithTitle = $nameWithTitle;
        $this->city = $city;
        $this->link = $link;
        $this->profileId = $profileId;
        $this->address = $address;
        $this->zipcode = $zipcode;
        $this->lastName = $lastName;
        $this->position = $position;
        $this->firstName = $firstName;
        $this->speciality = $speciality;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNameWithTitle(): string
    {
        return $this->nameWithTitle;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function getProfileId(): ?int
    {
        return $this->profileId;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getPosition(): ?Point
    {
        return $this->position;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }
}
