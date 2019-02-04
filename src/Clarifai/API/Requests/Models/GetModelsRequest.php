<?php

namespace Clarifai\API\Requests\Models;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Models\Model;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\Internal\_ListModelsRequest;
use Clarifai\Internal\_Model;
use Clarifai\Internal\_MultiModelResponse;

class GetModelsRequest extends ClarifaiRequest
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
        return '/v2/models';
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $response = $grpcClient->ListModels(new _ListModelsRequest());
        return $response;
    }

    /**
     * @param _MultiModelResponse $modelsResponse
     * @return Model[]
     * @throws \Clarifai\Exceptions\ClarifaiException
     */
    protected function unmarshaller($modelsResponse)
    {
        $models = [];
        /* @var _Model $model */
        foreach ($modelsResponse->getModels() as $model) {
            $typeExt = $model->getOutputInfo()->getTypeExt();

            $modelType = ModelType::determineModelType($typeExt);
            if (is_null($modelType)) {
                echo "Warning: Unknown model type '$typeExt', skipping. Please upgrade the to " .
                    "the latest version of the library.";
            }
            array_push($models, Model::deserialize($this->httpClient, $modelType, $model));
        }
        return $models;
    }
}
