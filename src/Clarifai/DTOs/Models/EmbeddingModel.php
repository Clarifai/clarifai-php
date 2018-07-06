<?php

namespace Clarifai\DTOs\Models;

use Clarifai\API\ClarifaiClientInterface;
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

    public function __construct(ClarifaiClientInterface $client, $modelID)
    {
        parent::__construct($client, $modelID);
    }

    /**
     * @param ClarifaiClientInterface $client
     * @param _Model $modelResponse
     * @return EmbeddingModel
     */
    public static function deserializeInner(ClarifaiClientInterface $client, $modelResponse) {
        return (new EmbeddingModel($client, $modelResponse->getId()))
            ->withName($modelResponse->getName())
            ->withCreatedAt($modelResponse->getCreatedAt()->toDateTime())
            ->withAppID($modelResponse->getAppId())
            ->withOutputInfo(EmbeddingOutputInfo::deserialize($modelResponse->getOutputInfo()))
            ->withModelVersion(ModelVersion::deserialize($modelResponse->getModelVersion()));
    }
}
