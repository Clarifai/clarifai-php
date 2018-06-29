<?php

namespace Clarifai\API\Requests\Inputs;

use Clarifai\Grpc\Input;
use Clarifai\Grpc\MultiInputResponse;
use Clarifai\Grpc\PostInputsRequest;
use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;

class AddInputsRequest extends ClarifaiRequest
{
    private $inputs;

    /**
     * Ctor.
     * @param ClarifaiClientInterface $client
     * @param ClarifaiInput|ClarifaiInput[] $inputs
     */
    public function __construct(ClarifaiClientInterface $client, $inputs)
    {
        parent::__construct($client);
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
        return $grpcClient->PostInputs((new PostInputsRequest())
            ->setInputs($inputs));
    }

    /**
     * @param MultiInputResponse $response
     * @return mixed
     */
    protected function unmarshaller($response)
    {
        $inputs = [];
        /** @var \Clarifai\Grpc\Input $input */
        foreach ($response->getInputs() as $input) {
            array_push($inputs, ClarifaiURLImage::deserialize($input));
        }
        return $inputs;
    }
}
