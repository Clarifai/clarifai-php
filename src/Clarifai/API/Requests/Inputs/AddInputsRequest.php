<?php

namespace Clarifai\API\Requests\Inputs;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\Internal\_Input;
use Clarifai\Internal\_MultiInputResponse;
use Clarifai\Internal\_PostInputsRequest;

class AddInputsRequest extends ClarifaiRequest
{
    private $inputs;

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     * @param ClarifaiInput|ClarifaiInput[] $inputs
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient, $inputs)
    {
        parent::__construct($httpClient);
        $this->inputs = is_array($inputs) ? $inputs : [$inputs];
    }

    protected function requestMethod()
    {
        return RequestMethod::POST;
    }

    protected function url()
    {
        return '/v2/inputs';
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $inputs = [];
        foreach ($this->inputs as $input) {
            array_push($inputs, $input->serialize());
        }
        return $grpcClient->PostInputs((new _PostInputsRequest())
            ->setInputs($inputs));
    }

    /**
     * @param _MultiInputResponse $response
     * @return mixed
     */
    protected function unmarshaller($response)
    {
        $inputs = [];
        /** @var _Input $input */
        foreach ($response->getInputs() as $input) {
            array_push($inputs, ClarifaiURLImage::deserialize($input));
        }
        return $inputs;
    }
}
