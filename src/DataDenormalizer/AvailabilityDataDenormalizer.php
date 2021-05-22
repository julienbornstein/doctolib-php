<?php

declare(strict_types=1);

namespace Doctolib\DataDenormalizer;

class AvailabilityDataDenormalizer implements DataDenormalizerInterface
{
    public static function denormalize(array $data): array
    {
        $availabilities = $data['availabilities'] ?? [];

        foreach ($availabilities as &$availability) {
            foreach ($availability['slots'] as &$slot) {
                // $slot could be a date as string or an array with date_start, date_end, agenda_id, steps (todo: try to understand why ?)
                if (\is_string($slot)) {
                    $slot = ['start_date' => $slot];
                }
            }
        }

        if (0 < \count($availabilities)) {
            $data['availabilities'] = $availabilities;
        }

        return $data;
    }
}
