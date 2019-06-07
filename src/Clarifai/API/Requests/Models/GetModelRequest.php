<?php

namespace Clarifai\API\Requests\Models;

use Clarifai\DTOs\Models\ModelType;
use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Models\Model;
use Clarifai\Exceptions\ClarifaiException;
use Clarifai\Internal\_GetModelRequest;
use Clarifai\Internal\_SingleModelResponse;

/**
 * Retrieves a model.
 */
class GetModelRequest extends ClarifaiRequest
{
    private $type;
    private $modelID;

    /** @var string */
    private $modelVersionID;
    /**
     * @param string $val The model version ID.
     * @return GetModelRequest
     */
    public function withModelVersionID($val) { $this->modelVersionID = $val; return $this; }

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
        if ($this->modelVersionID == null) {
            return "/v2/models/{$this->modelID}/output_info";
        } else {
            return "/v2/models/{$this->modelID}/versions/{$this->modelVersionID}/output_info";
        }
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        return $grpcClient->GetModel(new _GetModelRequest());
    }

    /**
     * @param _SingleModelResponse $response
     * @return Model The serialized model.
     * @throws ClarifaiException
     */
    protected function unmarshaller($response)
    {
        return Model::deserialize($this->httpClient, $this->type, $response->getModel());
    }
}
