<?php

declare(strict_types=1);

namespace Doctolib\DataDenormalizer;

use Doctolib\Utils\ArrayUtils;

class BookingDataDenormalizer implements DataDenormalizerInterface
{
    public static function denormalize(array $body): array
    {
        $data = $body['data'] ?? [];
        if (0 === \count($data)) {
            return $body;
        }

        $agendas = $data['agendas'] ?? [];
        if (0 === \count($agendas)) {
            return $body;
        }

        $specialities = $data['specialities'] ?? [];
        $visitMotives = $data['visit_motives'] ?? [];

        foreach ($visitMotives as &$visitMotive) {
            $visitMotive['speciality'] = ArrayUtils::searchCollectionItemById($specialities, $visitMotive['speciality_id']);
            unset($visitMotive['speciality_id']);
        }

        foreach ($agendas as &$agenda) {
            $agenda['visit_motives'] = array_filter(array_values(array_map(
                fn (int $visitMotiveId) => ArrayUtils::searchCollectionItemById($visitMotives, $visitMotiveId),
                $agenda['visit_motive_ids']
            )));

            foreach ($agenda['visit_motive_ids_by_practice_id'] as $practiceId => $visitMotiveIdsByPracticeIds) {
                $agenda['visit_motive_by_practice_id'][$practiceId] = array_filter(array_values(array_map(
                    fn (int $visitMotiveIdsByPracticeId) => ArrayUtils::searchCollectionItemById($visitMotives, $visitMotiveIdsByPracticeId),
                    $visitMotiveIdsByPracticeIds
                )));
            }

            unset($agenda['visit_motive_ids_by_practice_id'], $agenda['visit_motive_ids']);
        }

        unset($data['visit_motives'], $data['specialities']);

        $data['agendas'] = $agendas;
        $body['data'] = $data;

        return $body;
    }
}
