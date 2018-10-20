<?php

namespace Clarifai\API\Requests\Models;

use Clarifai\DTOs\Models\ModelType;
use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Models\Model;
use Clarifai\Internal\_GetModelRequest;
use Clarifai\Internal\_SingleModelResponse;

/**
 * Retrieves a model.
 */
class GetModelRequest extends ClarifaiRequest
{
    private $type;
    private $modelID;

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     * @param ModelType $type The prediction type.
     * @param string $modelID The model ID.
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient, $type, $modelID)
    {
        parent::__construct($httpClient);
        $this->type = $type;
        $this->modelID = $modelID;
    }

    protected function requestMethod()
    {
        return RequestMethod::GET;
    }

    protected function url()
    {
        return '/v2/models/' . $this->modelID . '/output_info';
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $r = $grpcClient->GetModel(new _GetModelRequest());
        return $r;
    }

    /**
     * @param _SingleModelResponse $response
     * @return Model The serialized model.
     * @throws \Clarifai\Exceptions\ClarifaiException
     */
    protected function unmarshaller($response)
    {
        return Model::deserialize($this->httpClient, $this->type, $response->getModel());
    }
}
