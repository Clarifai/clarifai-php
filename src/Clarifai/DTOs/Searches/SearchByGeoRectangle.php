<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\DTOs\GeoPoint;
use Clarifai\Internal\_And;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_Geo;
use Clarifai\Internal\_GeoBoxedPoint;
use Clarifai\Internal\_Input;

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
        return ((new _And())
            ->setInput((new _Input())
                ->setData((new _Data())
                    ->setGeo((new _Geo())
                        ->setGeoBox([
                            (new _GeoBoxedPoint())->setGeoPoint($this->geoPoint1->serialize()),
                            (new _GeoBoxedPoint())->setGeoPoint($this->geoPoint2->serialize())
                        ])))));
    }
}
