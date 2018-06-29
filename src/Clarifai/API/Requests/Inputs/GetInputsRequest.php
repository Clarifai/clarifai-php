<?php

namespace Clarifai\API\Requests\Inputs;

use Clarifai\API\Requests\ClarifaiPaginatedRequest;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\Grpc\ListInputsRequest;
use Clarifai\Grpc\MultiInputResponse;
use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;

class GetInputsRequest extends ClarifaiPaginatedRequest
{

    /**
     * Ctor.
     * @param ClarifaiClientInterface $client the clarifai client
     */
    public function __construct(ClarifaiClientInterface $client)
    {
        parent::__construct($client);
    }

    protected function requestMethod()
    {
        return RequestMethod::GET;
    }

    protected function url()
    {
        return "/v2/inputs";
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        return $grpcClient->ListInputs(new ListInputsRequest());
    }

    /**
     * @param MultiInputResponse $inputsResponse
     * @return ClarifaiInput[] The array of inputs
     */
    protected function unmarshaller($inputsResponse)
    {
        $inputs = [];
        foreach ($inputsResponse->getInputs() as $input)
        {
            array_push($inputs, ClarifaiInput::deserialize($input));
        }
        return $inputs;
    }
}
