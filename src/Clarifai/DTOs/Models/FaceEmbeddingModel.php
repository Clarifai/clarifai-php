<?php

namespace Clarifai\DTOs\Models;

use Clarifai\API\ClarifaiClientInterface;
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

    public function __construct(ClarifaiClientInterface $client, $modelID)
    {
        parent::__construct($client, $modelID);
    }

    /**
     * @param ClarifaiClientInterface $client
     * @param _Model $modelResponse
     * @return FaceEmbeddingModel
     */
    public static function deserializeInner(ClarifaiClientInterface $client, $modelResponse) {
        return (new FaceEmbeddingModel($client, $modelResponse->getId()))
            ->withName($modelResponse->getName())
            ->withCreatedAt($modelResponse->getCreatedAt()->toDateTime())
            ->withAppID($modelResponse->getAppId())
            ->withOutputInfo(FaceEmbeddingOutputInfo::deserialize($modelResponse->getOutputInfo()))
            ->withModelVersion(ModelVersion::deserialize($modelResponse->getModelVersion()));
    }
}
