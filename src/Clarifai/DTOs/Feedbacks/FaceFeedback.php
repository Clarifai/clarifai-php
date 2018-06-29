<?php

namespace Clarifai\DTOs\Feedbacks;

use Clarifai\Grpc\Face;
use Clarifai\Grpc\FaceIdentity;

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
     * @return Face
     */
    public function serialize()
    {
        $concepts = [];
        foreach ($this->identityConceptFeedbacks as $conceptFeedback) {
            array_push($concepts, $conceptFeedback->serialize());
        }
        return (new Face())
            ->setIdentity((new FaceIdentity())
                ->setConcepts($concepts));
    }
}
