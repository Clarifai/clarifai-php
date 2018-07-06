<?php

namespace Clarifai\DTOs\Feedbacks;

use Clarifai\Internal\_RegionInfoFeedback;

/**
 * Feedback to give to the region's prediction.
 */
class Feedback
{
    public static function accurate()
    {
        return new Feedback(_RegionInfoFeedback::accurate);
    }

    public static function misplaced()
    {
        return new Feedback(_RegionInfoFeedback::misplaced);
    }

    public static function notDetected()
    {
        return new Feedback(_RegionInfoFeedback::not_detected);
    }

    public static function falsePositive()
    {
        return new Feedback(_RegionInfoFeedback::false_positive);
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
