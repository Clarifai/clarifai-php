<?php

namespace Clarifai\DTOs\Predictions;

use Clarifai\DTOs\Crop;
use Clarifai\Internal\_Concept;
use Clarifai\Internal\_Region;

class Region
{
    private $id;
    /**
     * @return string
     */
    public function id() { return $this->id; }

    private $crop;
    /**
     * @return Crop
     */
    public function crop() { return $this->crop; }

    private $concepts;
    /**
     * @return Concept[]
     */
    public function concepts() { return $this->concepts; }

    /**
     * Ctor.
     * @param string $id
     * @param Crop $crop
     * @param Concept[] $concepts
     */
    public function __construct($id, $crop, $concepts)
    {
        $this->id = $id;
        $this->crop = $crop;
        $this->concepts = $concepts;
    }

    /**
     * @param _Region $regionResponse
     * @return Region
     */
    public static function deserialize($regionResponse)
    {
        $concepts = [];
        if (!is_null($regionResponse->getData()) &&
            !is_null($regionResponse->getData()->getConcepts())) {
            /** @var _Concept $c */
            foreach ($regionResponse->getData()->getConcepts() as $c) {
                array_push($concepts, Concept::deserialize($c));
            }
        }
        $crop = null;
        if (!is_null($regionResponse->getRegionInfo()) &&
            !is_null($regionResponse->getRegionInfo()->getBoundingBox())) {
            $crop = Crop::deserialize($regionResponse->getRegionInfo()->getBoundingBox());
        }
        return new Region(
            $regionResponse->getId(),
            $crop,
            $concepts);
    }
}
