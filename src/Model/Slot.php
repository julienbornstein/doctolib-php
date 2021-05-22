<?php

declare(strict_types=1);

namespace Doctolib\Model;

class Slot
{
    private \DateTimeInterface $startDate;

    private ?\DateTimeInterface $endDate;

    /**
     * @var Step[]
     */
    private array $steps;

    private ?int $agendaId;

    /**
     * @param Step[] $steps
     */
    public function __construct(\DateTimeInterface $startDate, ?\DateTimeInterface $endDate = null, array $steps = [], ?int $agendaId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->steps = $steps;
        $this->agendaId = $agendaId;
    }

    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @return Step[]
     */
    public function getSteps(): array
    {
        return $this->steps;
    }

    public function getAgendaId(): ?int
    {
        return $this->agendaId;
    }
}
