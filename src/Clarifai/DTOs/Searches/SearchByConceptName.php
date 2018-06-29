<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\Grpc\Concept;
use Clarifai\Grpc\Data;
use Clarifai\Grpc\Input;
use Clarifai\Grpc\Output;

class SearchByConceptName extends SearchBy
{

    private $ownerObjectKey;
    private $conceptName;

    /**
     * Ctor.
     * @param string $ownerObjectKey
     * @param string $conceptName
     */
    public function __construct($ownerObjectKey, $conceptName)
    {
        $this->ownerObjectKey = $ownerObjectKey;
        $this->conceptName = $conceptName;
    }

    public function serialize()
    {
        $data = (new Data())
            ->setConcepts([(new Concept())->setName($this->conceptName)]);
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
