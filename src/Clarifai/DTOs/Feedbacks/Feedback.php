<?php

namespace Clarifai\DTOs\Feedbacks;
use Clarifai\Grpc\FeedbackInfo;
use Clarifai\Grpc\RegionInfoFeedback;

/**
 * Feedback to give to the region's prediction.
 */
class Feedback
{
    public static function accurate()
    {
        return new Feedback(RegionInfoFeedback::accurate);
    }

    public static function misplaced()
    {
        return new Feedback(RegionInfoFeedback::misplaced);
    }

    public static function notDetected()
    {
        return new Feedback(RegionInfoFeedback::not_detected);
    }

    public static function falsePositive()
    {
        return new Feedback(RegionInfoFeedback::false_positive);
    }

    private $value;
    /**
     * @return int The feedback value;
     */
    public function value() { return $this->value; }

    /**
     * Ctor.
     * @param string $value The feedback value.
     */
    private function __construct($value)
    {
        $this->value = $value;
    }
}
