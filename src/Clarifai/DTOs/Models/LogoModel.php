<?php

namespace Clarifai\DTOs\Models;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\DTOs\Models\OutputInfos\LogoOutputInfo;
use Clarifai\Internal\_Model;

/**
 * The logo model finds logos and regions where they are located.
 */
class LogoModel extends Model
{
    /**
     * @inheritdoc
     */
    public function type()
    {
        return ModelType::logo();
    }

    /**
     * @return LogoOutputInfo The output info.
     */
    public function outputInfo() { return $this->outputInfo; }

    public function __construct(ClarifaiClientInterface $client, $modelID)
    {
        parent::__construct($client, $modelID);
    }

    /**
     * @param ClarifaiClientInterface $client
     * @param _Model $modelResponse
     * @return LogoModel
     */
    public static function deserializeInner(ClarifaiClientInterface $client, $modelResponse) {
        return (new LogoModel($client, $modelResponse->getId()))
            ->withName($modelResponse->getName())
            ->withCreatedAt($modelResponse->getCreatedAt()->toDateTime())
            ->withAppID($modelResponse->getAppId())
            ->withOutputInfo(LogoOutputInfo::deserialize($modelResponse->getOutputInfo()))
            ->withModelVersion(ModelVersion::deserialize($modelResponse->getModelVersion()));
    }
}
