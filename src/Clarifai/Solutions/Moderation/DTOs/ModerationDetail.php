<?php

namespace Clarifai\Solutions\Moderation\DTOs;

use Clarifai\DTOs\Predictions\Concept;

class ModerationDetail
{

    private $concept;
    /**
     * @return Concept
     */
    public function concept() { return $this->concept; }
    private $code;
    /**
     * @return int
     */
    public function code() { return $this->code; }
    private $description;
    /**
     * @return string
     */
    public function description() { return $this->description; }
    private $thresholdMin;
    /**
     * @return float
     */
    public function thresholdMin() { return $this->thresholdMin; }
    private $thresholdMax;
    /**
     * @return float
     */
    public function thresholdMax() { return $this->thresholdMax; }

    private function __construct($concept, $code, $description, $thresholdMin, $thresholdMax)
    {
        $this->concept = $concept;
        $this->code = $code;
        $this->description = $description;
        $this->thresholdMin = $thresholdMin;
        $this->thresholdMax = $thresholdMax;
    }

    /**
     * @param array $jsonObject
     * @return ModerationDetail
     */
    public static function deserializeJson($jsonObject)
    {
        return new ModerationDetail(
            Concept::deserializeJson($jsonObject['concept']),
            $jsonObject['code'],
            $jsonObject['description'],
            $jsonObject['threshold_min'],
            $jsonObject['threshold_max']
        );
    }
}
