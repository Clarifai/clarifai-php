<?php

namespace Clarifai\API\Requests\Models;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Models\ModelVersion;
use Clarifai\Internal\_GetModelVersionRequest;
use Clarifai\Internal\_SingleModelVersionResponse;

/**
 * Retrieves a specific model version.
 */
class GetModelVersionRequest extends ClarifaiRequest
{

    private $modelID;
    private $modelVersionID;

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     * @param string $modelID The model ID.
     * @param string $modelVersionID The model version ID.
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient, $modelID, $modelVersionID)
    {
        parent::__construct($httpClient);
        $this->modelID = $modelID;
        $this->modelVersionID = $modelVersionID;
    }

    protected function requestMethod()
    {
        return RequestMethod::GET;
    }

    protected function url()
    {
        return "/v2/models/$this->modelID/versions/$this->modelVersionID";
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        return $grpcClient->GetModelVersion(new _GetModelVersionRequest());
    }

    /**
     * @param _SingleModelVersionResponse $response
     * @return ModelVersion
     */
    protected function unmarshaller($response)
    {
        return ModelVersion::deserialize($response->getModelVersion());
    }
}
