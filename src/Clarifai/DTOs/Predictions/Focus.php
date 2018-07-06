<?php

namespace Clarifai\DTOs\Predictions;

use Clarifai\DTOs\Crop;
use Clarifai\Internal\_Region;

class Focus implements PredictionInterface
{
    /**
     * @inheritdoc
     */
    public function type() { return 'focus'; }

    private $crop;
    /**
     * @return Crop The crop of the focus
     */
    public function crop() { return $this->crop; }

    private $density;
    /**
     * @return double The density.
     */
    public function density() { return $this->density; }

    private $value;
    /**
     * @return double The value.
     */
    public function value() { return $this->value; }

    /**
     * Ctor.
     * @param Crop $crop The crop.
     * @param double $density The density.
     * @param double $value The value.
     */
    private function __construct($crop, $density, $value)
    {
        $this->crop = $crop;
        $this->density = $density;
        $this->value = $value;
    }

    /**
     * @param _Region $regionResponse
     * @param $value
     * @return Focus
     */
    public static function deserialize($regionResponse, $value)
    {
        return new Focus(Crop::deserialize($regionResponse->getRegionInfo()->getBoundingBox()),
            $regionResponse->getData()->getFocus()->getDensity(), $value);
    }
}
