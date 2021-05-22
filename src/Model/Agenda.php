<?php

declare(strict_types=1);

namespace Doctolib\Model;

use Webmozart\Assert\Assert;

class Agenda
{
    private int $id;

    /**
     * @var VisitMotive[]
     */
    private array $visitMotives = [];

    /**
     * @var int[]
     */
    private array $visitMotiveIds = [];

    public function __construct(int $id, array $visitMotives = [])
    {
        $this->id = $id;
        $this->visitMotives = $visitMotives;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return VisitMotive[]
     */
    public function getVisitMotives(): array
    {
        return $this->visitMotives;
    }

    /**
     * @param VisitMotive[] $visitMotives
     */
    public function withVisitMotives(array $visitMotives): self
    {
        $agenda = clone $this;
        $agenda->visitMotives = $visitMotives;

        return $agenda;
    }

    /**
     * @return int[]
     *
     * @internal
     */
    public function getVisitMotiveIds(): array
    {
        return $this->visitMotiveIds;
    }

    /**
     * @param int[] $visitMotiveIds
     *
     * @internal
     */
    public function setVisitMotiveIds(array $visitMotiveIds): void
    {
        $this->visitMotiveIds = $visitMotiveIds;
    }

    /**
     * @return VisitMotive[]
     */
    public static function getVisitMotivesForAgendas(array $agendas): array
    {
        Assert::allIsInstanceOf($agendas, self::class);

        $visitMotives = [];

        foreach ($agendas as $agenda) {
            foreach ($agenda->getVisitMotives() as $visitMotive) {
                $visitMotives[] = $visitMotive;
            }
        }

        return $visitMotives;
    }
}
