<?php

namespace Clarifai\DTOs\Models;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\DTOs\Models\OutputInfos\DemographicsOutputInfo;
use Clarifai\Internal\_Model;

/**
 * The demographics model finds faces and their demographics appearances.
 */
class DemographicsModel extends Model
{
    /**
     * @inheritdoc
     */
    public function type()
    {
        return ModelType::demographics();
    }

    /**
     * @return DemographicsOutputInfo The output info.
     */
    public function outputInfo() { return $this->outputInfo; }

    public function __construct(ClarifaiClientInterface $client, $modelID)
    {
        parent::__construct($client, $modelID);
    }

    /**
     * @param ClarifaiClientInterface $client
     * @param _Model $modelResponse
     * @return DemographicsModel
     */
    public static function deserializeInner(ClarifaiClientInterface $client, $modelResponse) {
        return (new DemographicsModel($client, $modelResponse->getId()))
            ->withName($modelResponse->getName())
            ->withCreatedAt($modelResponse->getCreatedAt()->toDateTime())
            ->withAppID($modelResponse->getAppId())
            ->withOutputInfo(DemographicsOutputInfo::deserialize($modelResponse->getOutputInfo()))
            ->withModelVersion(ModelVersion::deserialize($modelResponse->getModelVersion()));
    }
}
