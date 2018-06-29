<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\DTOs\Crop;
use Clarifai\DTOs\GeoPoint;
use Clarifai\DTOs\GeoRadius;
use Clarifai\Grpc\Concept;
use Clarifai\Grpc\Data;
use Clarifai\Grpc\Geo;
use Clarifai\Grpc\Image;
use Clarifai\Grpc\Input;
use Clarifai\Grpc\Output;

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
        return ((new \Clarifai\Grpc\PBAnd())
            ->setInput((new Input())
                ->setData((new Data())
                    ->setGeo((new Geo())
                        ->setGeoPoint($this->geoPoint->serialize())
                        ->setGeoLimit($this->geoRadius->serialize())))));
    }
}
