<?php

namespace Clarifai\DTOs;

use Clarifai\Grpc\GeoLimit;

class GeoRadius
{
    private $value;
    /**
     * @return float The value.
     */
    public function value() { return $this->value; }

    private $unit;
    /**
     * @return GeoRadiusUnit The radius unit.
     */
    public function unit() { return $this->unit; }

    /**
     * Ctor.
     * @param float $value
     * @param GeoRadiusUnit $unit
     */
    public function __construct($value, $unit)
    {
        $this->value = $value;
        $this->unit = $unit;
    }

    /**
     * Serializes this object to a Protobuf object.
     * @return \Clarifai\Grpc\GeoLimit
     */
    public function serialize()
    {
        return (new GeoLimit())
            ->setType($this->unit->value())
            ->setValue($this->value);
    }
}
