<?php

declare(strict_types=1);

namespace Doctolib\Model;

class Patient
{
    private int $id;

    private string $firstName;

    private string $lastName;

    private string $maidenName;

    private string $email;

    private string $phoneNumber;

    private string $zipcode;

    private string $city;

    private string $address;

    //private string $gender; // API could return string or false !@#
    private \DateTimeInterface $birthdate;

    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    private \DateTimeInterface $consentedAt;

    private string $kind;

    private ?\DateTimeInterface $deletedAt;

    /**
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(int $id, string $firstName, string $lastName, string $maidenName, string $email, string $phoneNumber, string $zipcode, string $city, string $address, \DateTimeInterface $birthdate, \DateTimeInterface $createdAt, \DateTimeInterface $updatedAt, \DateTimeInterface $consentedAt, string $kind, ?\DateTimeInterface $deletedAt)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->maidenName = $maidenName;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->zipcode = $zipcode;
        $this->city = $city;
        $this->address = $address;
        $this->birthdate = $birthdate;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->consentedAt = $consentedAt;
        $this->kind = $kind;
        $this->deletedAt = $deletedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getMaidenName(): string
    {
        return $this->maidenName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getBirthdate(): \DateTimeInterface
    {
        return $this->birthdate;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getConsentedAt(): \DateTimeInterface
    {
        return $this->consentedAt;
    }

    public function getKind(): string
    {
        return $this->kind;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }
}
