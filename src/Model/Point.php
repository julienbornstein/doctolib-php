<?php

declare(strict_types=1);

namespace Doctolib\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Point
{
    /**
     * @SerializedName("lat")
     */
    private float $latitude;

    /**
     * @SerializedName("lng")
     */
    private float $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function toArray(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
