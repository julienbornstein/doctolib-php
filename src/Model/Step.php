<?php

declare(strict_types=1);

namespace Doctolib\Model;

class Step
{
    private \DateTimeInterface $startDate;

    private \DateTimeInterface $endDate;

    private int $visitMotiveId;

    private ?int $agendaId;

    private array $agendaIds;

    public function __construct(\DateTimeInterface $startDate, \DateTimeInterface $endDate, int $visitMotiveId, ?int $agendaId = null, array $agendaIds = [])
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->visitMotiveId = $visitMotiveId;
        $this->agendaId = $agendaId;
        $this->agendaIds = $agendaIds;
    }

    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTimeInterface
    {
        return $this->endDate;
    }

    public function getVisitMotiveId(): int
    {
        return $this->visitMotiveId;
    }

    public function getAgendaId(): int
    {
        return $this->agendaId;
    }

    public function getAgendaIds(): array
    {
        return $this->agendaIds;
    }
}
