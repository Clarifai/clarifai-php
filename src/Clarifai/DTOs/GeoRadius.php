<?php

namespace Clarifai\DTOs;

use Clarifai\Internal\_GeoLimit;

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
     * @return _GeoLimit
     */
    public function serialize()
    {
        return (new _GeoLimit())
            ->setType($this->unit->value())
            ->setValue($this->value);
    }
}
