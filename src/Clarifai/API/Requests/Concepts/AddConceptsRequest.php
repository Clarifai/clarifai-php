<?php

namespace Clarifai\API\Requests\Concepts;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Internal\_MultiConceptResponse;
use Clarifai\Internal\_PostConceptsRequest;

class AddConceptsRequest extends ClarifaiRequest
{

    private $concepts;

    /**
     * Ctor.
     * @param ClarifaiClientInterface $client the Clarifai client
     * @param Concept[]|Concept $concepts the concepts to add
     */
    public function __construct(ClarifaiClientInterface $client, $concepts)
    {
        parent::__construct($client);
        $this->concepts = is_array($concepts) ? $concepts : [$concepts];
    }

    protected function requestMethod()
    {
        return RequestMethod::POST;
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

        $response = $grpcClient->PostConcepts((new _PostConceptsRequest())
            ->setConcepts($concepts));
        return $response;
    }

    /**
     * @param _MultiConceptResponse $response
     * @return array
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
