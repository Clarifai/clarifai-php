<?php

namespace Clarifai\DTOs\Models;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\DTOs\Models\OutputInfos\FaceConceptsOutputInfo;
use Clarifai\Internal\_Model;

/**
 * The face concepts model finds regions where faces are detected, and associates concepts to those
 * regions.
 */
class FaceConceptsModel extends Model
{
    /**
     * @inheritdoc
     */
    public function type()
    {
        return ModelType::faceConcepts();
    }

    /**
     * @return FaceConceptsOutputInfo The output info.
     */
    public function outputInfo() { return $this->outputInfo; }

    public function __construct(ClarifaiClientInterface $client, $modelID)
    {
        parent::__construct($client, $modelID);
    }

    /**
     * @param ClarifaiClientInterface $client
     * @param _Model $modelResponse
     * @return FaceConceptsModel
     */
    public static function deserializeInner(ClarifaiClientInterface $client, $modelResponse) {
        return (new FaceConceptsModel($client, $modelResponse->getId()))
            ->withName($modelResponse->getName())
            ->withCreatedAt($modelResponse->getCreatedAt()->toDateTime())
            ->withAppID($modelResponse->getAppId())
            ->withOutputInfo(FaceConceptsOutputInfo::deserialize($modelResponse->getOutputInfo()))
            ->withModelVersion(ModelVersion::deserialize($modelResponse->getModelVersion()));
    }
}
