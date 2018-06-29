<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\Grpc\Concept;
use Clarifai\Grpc\Data;
use Clarifai\Grpc\Input;
use Clarifai\Grpc\Output;

class SearchByConceptID extends SearchBy
{

    private $ownerObjectKey;
    private $conceptID;

    /**
     * Ctor.
     * @param string $ownerObjectKey
     * @param string $conceptID
     */
    public function __construct($ownerObjectKey, $conceptID)
    {
        $this->ownerObjectKey = $ownerObjectKey;
        $this->conceptID = $conceptID;
    }

    public function serialize()
    {
        $data = (new Data())
            ->setConcepts([(new Concept())->setId($this->conceptID)]);
        if ($this->ownerObjectKey == 'input') {
            return ((new \Clarifai\Grpc\PBAnd())
                ->setInput((new Input())
                    ->setData($data)));
        } else if ($this->ownerObjectKey == 'output') {
            return ((new \Clarifai\Grpc\PBAnd())
                ->setOutput((new Output())
                    ->setData($data)));
        } else {
            throw new \Exception('Unknown $ownerObjectKey: ' . $this->ownerObjectKey);
        }
    }
}
