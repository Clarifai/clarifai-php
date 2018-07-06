<?php

namespace Clarifai\DTOs\Predictions;

use Clarifai\DTOs\Crop;
use Clarifai\Internal\_Region;

class FaceDetection implements PredictionInterface
{
    /**
     * @inheritdoc
     */
    public function type() { return 'faceDetection'; }

    private $crop;
    /**
     * @return Crop The crop in which the face is located.
     */
    public function crop() { return $this->crop; }

    /**
     * Ctor.
     * @param Crop $crop The crop.
     */
    private function __construct($crop)
    {
        $this->crop = $crop;
    }

    /**
     * @param _Region $regionResponse
     * @return FaceDetection
     */
    public static function deserialize($regionResponse)
    {
        return new FaceDetection(Crop::deserialize(
            $regionResponse->getRegionInfo()->getBoundingBox()));
    }
}
