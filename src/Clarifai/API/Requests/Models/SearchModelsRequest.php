<?php

namespace Clarifai\API\Requests\Models;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiPaginatedRequest;
use Clarifai\DTOs\Models\Model;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\Internal\_Model;
use Clarifai\Internal\_ModelQuery;
use Clarifai\Internal\_MultiModelResponse;
use Clarifai\Internal\_PostModelsSearchesRequest;

/**
 * Search all the models by name and type of the model.
 */
class SearchModelsRequest extends ClarifaiPaginatedRequest
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var ModelType
     */
    private $modelType;

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     * @param string $name The name.
     * @param ModelType|null $modelType The model type.
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient, $name, $modelType = null)
    {
        parent::__construct($httpClient);
        $this->name = $name;
        $this->modelType = $modelType;
    }

    protected function requestMethod()
    {
        return RequestMethod::POST;
    }

    protected function url()
    {
        return '/v2/models/searches';
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $query = (new _ModelQuery())
            ->setName($this->name);
        if (!is_null($this->modelType)) {
            $query->setType($this->modelType->typeExt());
        }
        $request = (new _PostModelsSearchesRequest())
            ->setModelQuery($query);

        $this->addPaginationFieldsToRequest($request);

        return $grpcClient->PostModelsSearches($request);
    }

    /**
     * @param _MultiModelResponse $modelsResponse
     * @return Model[]
     */
    protected function unmarshaller($modelsResponse)
    {
        $models = [];
        /* @var _Model $model */
        foreach ($modelsResponse->getModels() as $model) {
            $typeExt = $model->getOutputInfo()->getTypeExt();

            $modelType = ModelType::determineModelType($typeExt);
            if (is_null($modelType)) {
                continue;
            }
            array_push($models, Model::deserialize($this->httpClient, $modelType, $model));
        }
        return $models;
    }
}
