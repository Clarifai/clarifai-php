<?php

namespace Clarifai\DTOs\Models;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\DTOs\Models\OutputInfos\EmbeddingOutputInfo;
use Clarifai\Internal\_Model;

class EmbeddingModel extends Model
{
    /**
     * @inheritdoc
     */
    public function type()
    {
        return ModelType::embedding();
    }

    /**
     * @return EmbeddingOutputInfo The output info.
     */
    public function outputInfo() { return $this->outputInfo; }

    public function __construct(ClarifaiHttpClientInterface $httpClient, $modelID)
    {
        parent::__construct($httpClient, $modelID);
    }

    /**
     * @param ClarifaiHttpClientInterface $httpClient
     * @param _Model $modelResponse
     * @return EmbeddingModel
     */
    public static function deserializeInner(ClarifaiHttpClientInterface $httpClient,
        $modelResponse) {
        return (new EmbeddingModel($httpClient, $modelResponse->getId()))
            ->withName($modelResponse->getName())
            ->withCreatedAt($modelResponse->getCreatedAt()->toDateTime())
            ->withAppID($modelResponse->getAppId())
            ->withOutputInfo(EmbeddingOutputInfo::deserialize($modelResponse->getOutputInfo()))
            ->withModelVersion(ModelVersion::deserialize($modelResponse->getModelVersion()));
    }
}
