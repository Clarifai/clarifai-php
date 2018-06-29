<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\DTOs\Crop;
use Clarifai\DTOs\GeoPoint;
use Clarifai\DTOs\GeoRadius;
use Clarifai\Grpc\Concept;
use Clarifai\Grpc\Data;
use Clarifai\Grpc\Geo;
use Clarifai\Grpc\GeoBoxedPoint;
use Clarifai\Grpc\Image;
use Clarifai\Grpc\Input;
use Clarifai\Grpc\Output;

class SearchByGeoRectangle extends SearchBy
{

    private $geoPoint1;
    private $geoPoint2;

    /**
     * Ctor.
     * @param GeoPoint $geoPoint1
     * @param GeoPoint $geoPoint2
     */
    public function __construct($geoPoint1, $geoPoint2)
    {
        $this->geoPoint1 = $geoPoint1;
        $this->geoPoint2 = $geoPoint2;
    }

    public function serialize()
    {
        return ((new \Clarifai\Grpc\PBAnd())
            ->setInput((new Input())
                ->setData((new Data())
                    ->setGeo((new Geo())
                        ->setGeoBox([
                            (new GeoBoxedPoint())->setGeoPoint($this->geoPoint1->serialize()),
                            (new GeoBoxedPoint())->setGeoPoint($this->geoPoint2->serialize())
                        ])))));
    }
}
