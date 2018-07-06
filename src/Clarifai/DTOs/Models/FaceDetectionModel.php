<?php

namespace Clarifai\DTOs\Models;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\DTOs\Models\OutputInfos\FaceDetectionOutputInfo;
use Clarifai\Internal\_Model;

/**
 * The face detection model finds regions where faces are detected.
 */
class FaceDetectionModel extends Model
{
    /**
     * @inheritdoc
     */
    public function type()
    {
        return ModelType::faceDetection();
    }

    /**
     * @return FaceDetectionOutputInfo The output info.
     */
    public function outputInfo() { return $this->outputInfo; }

    public function __construct(ClarifaiClientInterface $client, $modelID)
    {
        parent::__construct($client, $modelID);
    }

    /**
     * @param ClarifaiClientInterface $client
     * @param _Model $modelResponse
     * @return FaceDetectionModel
     */
    public static function deserializeInner(ClarifaiClientInterface $client, $modelResponse) {
        return (new FaceDetectionModel($client, $modelResponse->getId()))
            ->withName($modelResponse->getName())
            ->withCreatedAt($modelResponse->getCreatedAt()->toDateTime())
            ->withAppID($modelResponse->getAppId())
            ->withOutputInfo(FaceDetectionOutputInfo::deserialize($modelResponse->getOutputInfo()))
            ->withModelVersion(ModelVersion::deserialize($modelResponse->getModelVersion()));
    }
}
