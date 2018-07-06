<?php

namespace Clarifai\DTOs\Predictions;

use Clarifai\Internal\_Frame;

class Frame implements PredictionInterface
{
    /**
     * @inheritdoc
     */
    public function type() { return 'frame'; }

    private $index;
    /**
     * @return int The index.
     */
    public function index() { return $this->index; }

    private $time;
    /**
     * @return int The time.
     */
    public function time() { return $this->time; }

    private $concepts;
    /**
     * @return Concept[] The concepts.
     */
    public function concepts() { return $this->concepts; }

    /**
     * Ctor.
     * @param int $index The index.
     * @param int $time The time.
     * @param Concept[] $concepts The concepts.
     */
    private function __construct($index, $time, $concepts)
    {
        $this->index = $index;
        $this->time = $time;
        $this->concepts = $concepts;
    }

    /**
     * @param _Frame $frameResponse
     * @return Frame
     */
    public static function deserialize($frameResponse)
    {
        $frameInfo = $frameResponse->getFrameInfo();
        $concepts = [];
        foreach ($frameResponse->getData()->getConcepts() as $concept) {
            array_push($concepts, Concept::deserialize($concept));
        }
        return new Frame($frameInfo->getIndex(), $frameInfo->getTime(), $concepts);
    }
}
