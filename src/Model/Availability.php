<?php

declare(strict_types=1);

namespace Doctolib\Model;

class Availability
{
    private \DateTimeInterface $date;

    /**
     * @var Slot[]
     */
    private array $slots;

    /**
     * @param Slot[] $slots
     */
    public function __construct(\DateTimeInterface $date, array $slots)
    {
        $this->date = $date;
        $this->slots = $slots;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return Slot[]
     */
    public function getSlots(): array
    {
        return $this->slots;
    }
}
