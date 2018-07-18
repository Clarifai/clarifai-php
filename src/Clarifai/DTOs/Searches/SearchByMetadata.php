<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\DTOs\GeoPoint;
use Clarifai\Helpers\ProtobufHelper;
use Clarifai\Internal\_And;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_Geo;
use Clarifai\Internal\_GeoBoxedPoint;
use Clarifai\Internal\_Input;
use Clarifai\Internal\_Output;

class SearchByMetadata extends SearchBy
{

    private $metadata;

    /**
     * Ctor.
     * @param array $metadata
     */
    public function __construct($metadata)
    {
        $this->metadata = $metadata;
    }

    public function serialize()
    {
        $pbh = new ProtobufHelper();
        return ((new _And())
            ->setInput((new _Input())
                ->setData((new _Data())
                    ->setMetadata($pbh->arrayToStruct($this->metadata)))));
    }
}
