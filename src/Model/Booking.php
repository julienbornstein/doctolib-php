<?php

declare(strict_types=1);

namespace Doctolib\Model;

class Booking
{
    private Profile $profile;

    /**
     * @var Agenda[]
     */
    private array $agendas;

    /**
     * @param Agenda[] $agendas
     */
    public function __construct(Profile $profile, array $agendas)
    {
        $this->profile = $profile;
        $this->agendas = $agendas;
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }

    /**
     * @return Agenda[]
     */
    public function getAgendas(): array
    {
        return $this->agendas;
    }

    /**
     * @return VisitMotive[]
     */
    public function getVisitMotives(): array
    {
        $visitMotives = [];

        foreach ($this->agendas as $agenda) {
            foreach ($agenda->getVisitMotives() as $visitMotive) {
                $visitMotives[] = $visitMotive;
            }
        }

        return $visitMotives;
    }
}
