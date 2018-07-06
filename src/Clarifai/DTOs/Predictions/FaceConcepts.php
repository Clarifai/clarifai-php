<?php

namespace Clarifai\DTOs\Predictions;

use Clarifai\DTOs\Crop;
use Clarifai\Internal\_Region;

class FaceConcepts implements PredictionInterface
{
    /**
     * @inheritdoc
     */
    public function type() { return 'faceConcepts'; }

    private $crop;
    /**
     * @return Crop The crop in which the face is located.
     */
    public function crop() { return $this->crop; }

    private $concepts;
    /**
     * @return Concept[] The concepts.
     */
    public function concepts() { return $this->concepts; }

    /**
     * Ctor.
     * @param Crop $crop The crop.
     * @param Concept[] $concepts The concepts.
     */
    private function __construct($crop, $concepts)
    {
        $this->crop = $crop;
        $this->concepts = $concepts;
    }

    /**
     * @param _Region $regionResponse
     * @return FaceConcepts
     */
    public static function deserialize($regionResponse)
    {
        $face = $regionResponse->getData()->getFace();

        $concepts = [];
        foreach ($face->getIdentity()->getConcepts() as $concept) {
            array_push($concepts, Concept::deserialize($concept));
        }

        return new FaceConcepts(
            Crop::deserialize($regionResponse->getRegionInfo()->getBoundingBox()), $concepts);
    }
}
