<?php

namespace Clarifai\DTOs;

/**
 * Units used in geographical radius.
 *
 * Note: since latitude/longitude are angles, it's possible to express distance as an angle in
 * degrees or radians.
 */
class GeoRadiusUnit
{
    public static function withinMiles() { return new GeoRadiusUnit('withinMiles'); }
    public static function withinKilometers() { return new GeoRadiusUnit('withinKilometers'); }
    public static function withinDegrees() { return new GeoRadiusUnit('withinDegrees'); }
    public static function withinRadians() { return new GeoRadiusUnit('withinRadians'); }

    private $value;
    /**
     * @return string
     */
    public function value() { return $this->value; }

    private function __construct($value)
    {
        $this->value = $value;
    }
}
