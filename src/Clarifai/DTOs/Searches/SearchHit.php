<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\Internal\_Hit;

class SearchHit
{
    /**
     * @var float
     */
    private $score;
    /**
     * @return float
     */
    public function score() { return $this->score; }

    /**
     * @var ClarifaiInput
     */
    private $input;
    /**
     * @return ClarifaiInput
     */
    public function input() { return $this->input; }

    /**
     * Ctor.
     * @param float $score
     * @param ClarifaiInput $input
     */
    private function __construct($score, $input)
    {
        $this->score = $score;
        $this->input = $input;
    }

    /**
     * @param _Hit $hitResponse
     * @return SearchHit
     */
    public static function deserialize($hitResponse)
    {
        return new SearchHit($hitResponse->getScore(),
            ClarifaiInput::deserialize($hitResponse->getInput()));
    }
}
