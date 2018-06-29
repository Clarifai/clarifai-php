<?php

namespace Clarifai\DTOs\Predictions;

class Embedding implements PredictionInterface
{
    /**
     * @inheritdoc
     */
    public function type() { return 'embedding'; }

    private $numDimensions;
    /**
     * @return int The number of dimensions.
     */
    public function numDimensions() { return $this->numDimensions; }

    private $vector;
    /**
     * @return double[] The vector.
     */
    public function vector() { return $this->vector; }

    /**
     * Ctor.
     * @param int $numDimensions The number of dimensions.
     * @param double[] $vector The vector.
     */
    private function __construct($numDimensions, $vector)
    {
        $this->numDimensions = $numDimensions;
        $this->vector = $vector;
    }

    /**
     * @param \Clarifai\Grpc\Embedding $embeddingResponse
     * @return Embedding
     */
    public static function deserialize($embeddingResponse)
    {
        $numDimensions = $embeddingResponse->getNumDimensions();
        $vector = [];
        for ($i = 0; $i < $embeddingResponse->getVector()->count(); $i++) {
            array_push($vector, $embeddingResponse->getVector()->offsetGet($i));
        }
        return new Embedding($numDimensions, $vector);
    }
}
