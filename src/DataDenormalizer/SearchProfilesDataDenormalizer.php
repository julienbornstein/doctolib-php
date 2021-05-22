<?php

declare(strict_types=1);

namespace Doctolib\DataDenormalizer;

class SearchProfilesDataDenormalizer implements DataDenormalizerInterface
{
    public static function denormalize(array $body): array
    {
        $data = $body['data'] ?? [];
        if (0 === \count($data)) {
            return $body;
        }

        $doctors = $data['doctors'] ?? [];
        if (0 === \count($doctors)) {
            return $body;
        }

        $speciality = $data['speciality'] ?? [];

        foreach ($doctors as &$doctor) {
            if ($speciality['name'] === $doctor['speciality']) {
                $doctor['speciality'] = $speciality;
            } else {
                $doctor['speciality'] = null; // or make Speciality::id nullable
            }
        }

        $data['doctors'] = $doctors;
        $body['data'] = $data;

        return $body;
    }
}
