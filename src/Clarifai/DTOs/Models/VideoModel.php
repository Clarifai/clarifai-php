<?php

namespace Clarifai\DTOs\Models;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\DTOs\Models\OutputInfos\VideoOutputInfo;
use Clarifai\Helpers\DateTimeHelper;
use Clarifai\Internal\_Model;

/**
 * The video model runs predictions on a video.
 */
class VideoModel extends Model
{
    /**
     * @inheritdoc
     */
    public function type()
    {
        return ModelType::video();
    }

    /**
     * @return VideoOutputInfo The output info.
     */
    public function outputInfo() { return $this->outputInfo; }

    public function __construct(ClarifaiClientInterface $client, $modelID)
    {
        parent::__construct($client, $modelID);
    }

    /**
     * @param ClarifaiClientInterface $client
     * @param _Model $modelResponse
     * @return VideoModel
     */
    public static function deserializeInner(ClarifaiClientInterface $client, $modelResponse) {
        return (new VideoModel($client, $modelResponse->getId()))
            ->withName($modelResponse->getName())
            ->withCreatedAt($modelResponse->getCreatedAt()->toDateTime())
            ->withAppID($modelResponse->getAppId())
            ->withOutputInfo(VideoOutputInfo::deserialize($modelResponse->getOutputInfo()))
            ->withModelVersion(ModelVersion::deserialize($modelResponse->getModelVersion()));
    }
}
