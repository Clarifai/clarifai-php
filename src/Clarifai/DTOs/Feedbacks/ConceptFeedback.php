<?php

namespace Clarifai\DTOs\Feedbacks;

use Clarifai\Grpc\Concept;

/**
 * Concept feedback.
 */
class ConceptFeedback
{
    /**
     * @var string
     */
    private $conceptID;
    /**
     * @var bool
     */
    private $value;

    /**
     * Ctor.
     * @param string $conceptID The concept ID.
     * @param bool $value True if concept is present in the input, false if not present.
     */
    public function __construct($conceptID, $value)
    {
        $this->conceptID = $conceptID;
        $this->value = $value;
    }

    /**
     * Serializes this object to a Protobuf object.
     * @return Concept
     */
    public function serialize()
    {
        return (new Concept())
            ->setId($this->conceptID)
            ->setValue($this->value ? 1.0 : -1.0);
    }
}
