<?php

namespace Clarifai\DTOs\Models;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\DTOs\Models\OutputInfos\FaceEmbeddingOutputInfo;
use Clarifai\Internal\_Model;

/**
 * The face embedding model computes numerical embedding vectors for detected faces.
 */
class FaceEmbeddingModel extends Model
{
    /**
     * @inheritdoc
     */
    public function type()
    {
        return ModelType::faceEmbedding();
    }

    /**
     * @return FaceEmbeddingOutputInfo The output info.
     */
    public function outputInfo() { return $this->outputInfo; }

    public function __construct(ClarifaiHttpClientInterface $httpClient, $modelID)
    {
        parent::__construct($httpClient, $modelID);
    }

    /**
     * @param ClarifaiHttpClientInterface $httpClient
     * @param _Model $modelResponse
     * @return FaceEmbeddingModel
     */
    public static function deserializeInner(ClarifaiHttpClientInterface $httpClient,
        $modelResponse) {
        return (new FaceEmbeddingModel($httpClient, $modelResponse->getId()))
            ->withName($modelResponse->getName())
            ->withCreatedAt($modelResponse->getCreatedAt()->toDateTime())
            ->withAppID($modelResponse->getAppId())
            ->withOutputInfo(FaceEmbeddingOutputInfo::deserialize($modelResponse->getOutputInfo()))
            ->withModelVersion(ModelVersion::deserialize($modelResponse->getModelVersion()));
    }
}
