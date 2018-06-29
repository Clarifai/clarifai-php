<?php

namespace Clarifai\API\Requests\Concepts;

use Clarifai\Grpc\MultiConceptResponse;
use Clarifai\Grpc\PatchConceptsRequest;
use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Predictions\Concept;

class ModifyConceptsRequest extends ClarifaiRequest
{
    private $concepts;

    /**
     * Ctor.
     * @param ClarifaiClientInterface $client the Clarifai client
     * @param Concept[]|Concept $concepts the concepts to modify
     */
    public function __construct(ClarifaiClientInterface $client, $concepts)
    {
        parent::__construct($client);
        $this->concepts = is_array($concepts) ? $concepts : [$concepts];
    }

    protected function requestMethod()
    {
        return RequestMethod::PATCH;
    }

    protected function url()
    {
        return '/v2/concepts';
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $concepts = [];
        foreach ($this->concepts as $concept) {
            array_push($concepts, $concept->serialize());
        }
        $response = $grpcClient->PatchConcepts((new PatchConceptsRequest())
            ->setAction('overwrite')
            ->setConcepts($concepts));
        return $response;
    }

    /**
     * @param MultiConceptResponse $response
     * @return Concept[]
     */
    protected function unmarshaller($response)
    {
        $concepts = [];
        foreach ($response->getConcepts() as $concept) {
            array_push($concepts, Concept::deserialize($concept));
        }
        return $concepts;
    }
}
