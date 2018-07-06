<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\DTOs\GeoPoint;
use Clarifai\DTOs\GeoRadius;
use Clarifai\Internal\_And;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_Geo;
use Clarifai\Internal\_Input;

class SearchByGeoCircle extends SearchBy
{

    private $geoPoint;
    private $geoRadius;

    /**
     * Ctor.
     * @param GeoPoint $geoPoint
     * @param GeoRadius $geoRadius
     */
    public function __construct($geoPoint, $geoRadius)
    {
        $this->geoPoint = $geoPoint;
        $this->geoRadius = $geoRadius;
    }

    public function serialize()
    {
        return ((new _And())
            ->setInput((new _Input())
                ->setData((new _Data())
                    ->setGeo((new _Geo())
                        ->setGeoPoint($this->geoPoint->serialize())
                        ->setGeoLimit($this->geoRadius->serialize())))));
    }
}
