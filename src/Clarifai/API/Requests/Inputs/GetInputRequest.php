<?php

namespace Clarifai\API\Requests\Inputs;

use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\Internal\_GetInputRequest;
use Clarifai\Internal\_SingleInputResponse;

class GetInputRequest extends ClarifaiRequest
{
    private $inputID;

    /**
     * Ctor.
     * @param ClarifaiClientInterface $client the Clarifai client
     * @param string $inputID the input ID
     */
    public function __construct(ClarifaiClientInterface $client, $inputID)
    {
        parent::__construct($client);
        $this->inputID = $inputID;
    }

    protected function requestMethod()
    {
        return RequestMethod::GET;
    }

    protected function url()
    {
        return '/v2/inputs/' . $this->inputID;
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        return $grpcClient->GetInput((new _GetInputRequest()));
    }

    /**
     * @param _SingleInputResponse $inputResponse
     * @return ClarifaiInput The input.
     */
    protected function unmarshaller($inputResponse)
    {
        return ClarifaiInput::deserialize($inputResponse->getInput());
    }
}