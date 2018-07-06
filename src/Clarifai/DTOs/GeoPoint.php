<?php

namespace Clarifai\DTOs;

use Clarifai\Internal\_GeoPoint;

class GeoPoint
{
    /**
     * @var float
     */
    private $longitude;
    /**
     * @return float The longitude axis.
     */
    public function longitude() { return $this->longitude; }

    /**
     * @var float
     */
    private $latitude;
    /**
     * @return float The latitude axis.
     */
    public function latitude() { return $this->latitude; }

    /**
     * Ctor.
     * @param float $longitude The longitude axis.
     * @param float $latitude The latitude axis.
     */
    public function __construct($longitude, $latitude)
    {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    /**
     * Returns a new point moved by the new coordinates.
     * @param float $longitude The longitude to translate by.
     * @param float $latitude The latitude to translate by.
     * @return GeoPoint A translated geographical point.
     */
    public function translated($longitude, $latitude)
    {
        return new GeoPoint($this->longitude + $longitude, $this->latitude + $latitude);
    }

    /**
     * Serializes this object to a Protobuf object.
     * @return _GeoPoint
     */
    public function serialize()
    {
        return (new _GeoPoint())
            ->setLongitude($this->longitude)
            ->setLatitude($this->latitude);
    }

    /**
     * @param _GeoPoint $geoPointResponse
     * @return GeoPoint
     */
    public static function deserialize($geoPointResponse)
    {
        return new GeoPoint($geoPointResponse->getLongitude(), $geoPointResponse->getLatitude());
    }
}
