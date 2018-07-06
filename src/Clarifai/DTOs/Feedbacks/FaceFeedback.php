<?php

namespace Clarifai\DTOs\Feedbacks;

use Clarifai\Internal\_Face;
use Clarifai\Internal\_FaceIdentity;

class FaceFeedback
{
    /**
     * @var ConceptFeedback[]
     */
    private $identityConceptFeedbacks;

    /**
     * Ctor.
     * @param ConceptFeedback[] $identityConceptFeedbacks The identity concept feedbacks.
     */
    public function __construct($identityConceptFeedbacks)
    {
        $this->identityConceptFeedbacks = $identityConceptFeedbacks;
    }

    /**
     * Serializes this object to a Protobuf object.
     * @return _Face
     */
    public function serialize()
    {
        $concepts = [];
        foreach ($this->identityConceptFeedbacks as $conceptFeedback) {
            array_push($concepts, $conceptFeedback->serialize());
        }
        return (new _Face())
            ->setIdentity((new _FaceIdentity())
                ->setConcepts($concepts));
    }
}
