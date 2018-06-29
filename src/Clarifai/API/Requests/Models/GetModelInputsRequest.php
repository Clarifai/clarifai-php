<?php

namespace Clarifai\API\Requests\Models;

use Clarifai\API\Requests\ClarifaiPaginatedRequest;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\Grpc\ListModelInputsRequest;
use Clarifai\Grpc\ListModelsRequest;
use Clarifai\Grpc\MultiModelResponse;
use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Models\Model;
use Clarifai\DTOs\Models\ModelType;

class GetModelInputsRequest extends ClarifaiPaginatedRequest
{
    /**
     * @var string
     */
    private $modelID;

    private $modelVersionID;
    /**
     * @param string $val
     * @return GetModelInputsRequest
     */
    public function withModelVersionID($val) { $this->modelVersionID = $val; return $this; }

    /**
     * Ctor.
     * @param ClarifaiClientInterface $client The Clarifai client.
     * @param string $modelID The model ID.
     */
    public function __construct(ClarifaiClientInterface $client, $modelID)
    {
        parent::__construct($client);
        $this->modelID = $modelID;
    }

    protected function requestMethod()
    {
        return RequestMethod::GET;
    }

    protected function url()
    {
        if (is_null($this->modelVersionID)) {
            return "/v2/models/$this->modelID/inputs";
        } else {
            return "/v2/models/$this->modelID/versions/$this->modelVersionID/inputs";
        }
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $response = $grpcClient->ListModelInputs(new ListModelInputsRequest());
        return $response;
    }

    /**
     * @param \Clarifai\Grpc\MultiInputResponse $inputsResponse
     * @return ClarifaiInput[]
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
