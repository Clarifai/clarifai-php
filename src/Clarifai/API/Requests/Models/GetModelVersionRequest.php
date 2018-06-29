<?php

namespace Clarifai\API\Requests\Models;

use Clarifai\Grpc\SingleModelVersionResponse;
use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Models\ModelVersion;

/**
 * Retrieves a specific model version.
 */
class GetModelVersionRequest extends ClarifaiRequest
{

    private $modelID;
    private $modelVersionID;

    /**
     * Ctor.
     * @param ClarifaiClientInterface $client The Clarifai client.
     * @param string $modelID The model ID.
     * @param string $modelVersionID The model version ID.
     */
    public function __construct(ClarifaiClientInterface $client, $modelID, $modelVersionID)
    {
        parent::__construct($client);
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
        return $grpcClient->GetModelVersion(new \Clarifai\Grpc\GetModelVersionRequest());
    }

    /**
     * @param SingleModelVersionResponse $response
     * @return ModelVersion
     */
    protected function unmarshaller($response)
    {
        return ModelVersion::deserialize($response->getModelVersion());
    }
}
