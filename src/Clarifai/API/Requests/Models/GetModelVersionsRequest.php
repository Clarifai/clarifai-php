<?php

namespace Clarifai\API\Requests\Models;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Models\ModelVersion;
use Clarifai\Internal\_ListModelVersionsRequest;
use Clarifai\Internal\_ModelVersion;
use Clarifai\Internal\_MultiModelVersionResponse;

/**
 * Retrieves all model's versions.
 */
class GetModelVersionsRequest extends ClarifaiRequest
{
    /**
     * @var string
     */
    private $modelID;

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
        return "/v2/models/$this->modelID/versions";
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        return $grpcClient->ListModelVersions(new _ListModelVersionsRequest());
    }

    /**
     * @param _MultiModelVersionResponse $response
     * @return ModelVersion[] The model versions.
     */
    protected function unmarshaller($response)
    {
        $result = [];
        /** @var _ModelVersion $modelVersion */
        foreach ($response->getModelVersions() as $modelVersion) {
            array_push($result, ModelVersion::deserialize($modelVersion));
        }
        return $result;
    }
}
