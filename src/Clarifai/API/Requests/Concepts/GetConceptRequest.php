<?php

namespace Clarifai\API\Requests\Concepts;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Internal\_GetConceptRequest;
use Clarifai\Internal\_SingleConceptResponse;

class GetConceptRequest extends ClarifaiRequest
{
    private $conceptID;

    /**
     * Ctor.
     * @param ClarifaiClientInterface $client the Clarifai client
     * @param string $conceptID the concept ID to retrieve
     */
    public function __construct(ClarifaiClientInterface $client, $conceptID)
    {
        parent::__construct($client);
        $this->conceptID = $conceptID;
    }

    protected function requestMethod()
    {
        return RequestMethod::GET;
    }

    protected function url()
    {
        return '/v2/concepts/' . $this->conceptID;
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $response = $grpcClient->GetConcept(new _GetConceptRequest());
        return $response;
    }

    /**
     * @param _SingleConceptResponse $response The response.
     * @return Concept The concept.
     */
    protected function unmarshaller($response)
    {
        return Concept::deserialize($response->getConcept());
    }
}
