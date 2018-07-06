<?php

namespace Clarifai\DTOs\Predictions;

use Clarifai\DTOs\Crop;
use Clarifai\Internal\_Region;

class FaceEmbedding implements PredictionInterface
{
    /**
     * @inheritdoc
     */
    public function type() { return 'faceEmbedding'; }

    private $crop;
    /**
     * @return Crop The crop in which the face is located.
     */
    public function crop() { return $this->crop; }

    private $embeddings;
    /**
     * @return Embedding[] The embeddings.
     */
    public function embeddings() { return $this->embeddings; }

    /**
     * Ctor.
     * @param Crop $crop The crop.
     * @param Embedding[] $embeddings The embeddings.
     */
    private function __construct($crop, $embeddings)
    {
        $this->crop = $crop;
        $this->embeddings = $embeddings;
    }

    /**
     * @param _Region $regionResponse
     * @return FaceEmbedding
     */
    public static function deserialize($regionResponse)
    {
        $embeddings = [];
        foreach ($regionResponse->getData()->getEmbeddings() as $embedding) {
            array_push($embeddings, Embedding::deserialize($embedding));
        }

        return new FaceEmbedding(Crop::deserialize($regionResponse->getRegionInfo()->getBoundingBox()),
            $embeddings);
    }
}
