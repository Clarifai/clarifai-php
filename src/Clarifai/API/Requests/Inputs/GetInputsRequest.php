<?php

namespace Clarifai\API\Requests\Inputs;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\Requests\ClarifaiPaginatedRequest;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\Internal\_ListInputsRequest;
use Clarifai\Internal\_MultiInputResponse;

class GetInputsRequest extends ClarifaiPaginatedRequest
{

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient)
    {
        parent::__construct($httpClient);
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
        return $grpcClient->ListInputs(new _ListInputsRequest());
    }

    /**
     * @param _MultiInputResponse $inputsResponse
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
