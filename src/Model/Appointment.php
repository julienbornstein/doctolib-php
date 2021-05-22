<?php

declare(strict_types=1);

namespace Doctolib\Model;

class Appointment
{
    private string $id;

    private \DateTimeInterface $startDate;

    private \DateTimeInterface $endDate;

    private int $agendaId;

    private ?bool $finalStep;

    private ?int $visitMotiveId;

    private ?string $redirection;

    private ?string $temporaryAppointmentId;

    public function __construct(string $id, \DateTimeInterface $startDate, \DateTimeInterface $endDate, int $agendaId, ?bool $finalStep = null, ?int $visitMotiveId = null, ?string $redirection = null, ?string $temporaryAppointmentId = null)
    {
        $this->id = $id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->agendaId = $agendaId;
        $this->finalStep = $finalStep;
        $this->visitMotiveId = $visitMotiveId;
        $this->redirection = $redirection;
        $this->temporaryAppointmentId = $temporaryAppointmentId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTimeInterface
    {
        return $this->endDate;
    }

    public function getAgendaId(): int
    {
        return $this->agendaId;
    }

    public function isFinalStep(): ?bool
    {
        return $this->finalStep;
    }

    public function getVisitMotiveId(): ?int
    {
        return $this->visitMotiveId;
    }

    public function getRedirection(): ?string
    {
        return $this->redirection;
    }

    public function getTemporaryAppointmentId(): ?string
    {
        return $this->temporaryAppointmentId;
    }

    public function setTemporaryAppointmentId(?string $temporaryAppointmentId): void
    {
        $this->temporaryAppointmentId = $temporaryAppointmentId;
    }
}
