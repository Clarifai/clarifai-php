<?php

namespace Clarifai\DTOs\Predictions;

use Clarifai\DTOs\Crop;
use Clarifai\Internal\_Region;

class Logo implements PredictionInterface
{
    /**
     * @inheritdoc
     */
    public function type() { return 'logo'; }

    private $crop;
    /**
     * @return Crop The crop in which the logo is located.
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
     * @return Logo
     */
    public static function deserialize($regionResponse)
    {
        $concepts = [];
        foreach ($regionResponse->getData()->getConcepts() as $concept) {
            array_push($concepts, Concept::deserialize($concept));
        }

        return new Logo(Crop::deserialize($regionResponse->getRegionInfo()->getBoundingBox()),
            $concepts);
    }
}
