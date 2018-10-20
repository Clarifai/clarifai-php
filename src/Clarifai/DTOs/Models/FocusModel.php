<?php

namespace Clarifai\DTOs\Models;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\DTOs\Models\OutputInfos\FocusOutputInfo;
use Clarifai\Internal\_Model;

/**
 * Focus model returs overall focus and identifies in-focus regions.
 */
class FocusModel extends Model
{
    /**
     * @inheritdoc
     */
    public function type()
    {
        return ModelType::focus();
    }

    /**
     * @return FocusOutputInfo The output info.
     */
    public function outputInfo() { return $this->outputInfo; }

    public function __construct(ClarifaiHttpClientInterface $httpClient, $modelID)
    {
        parent::__construct($httpClient, $modelID);
    }

    /**
     * @param ClarifaiHttpClientInterface $httpClient
     * @param _Model $modelResponse
     * @return FocusModel
     */
    public static function deserializeInner(ClarifaiHttpClientInterface $httpClient,
        $modelResponse) {
        return (new FocusModel($httpClient, $modelResponse->getId()))
            ->withName($modelResponse->getName())
            ->withCreatedAt($modelResponse->getCreatedAt()->toDateTime())
            ->withAppID($modelResponse->getAppId())
            ->withOutputInfo(FocusOutputInfo::deserialize($modelResponse->getOutputInfo()))
            ->withModelVersion(ModelVersion::deserialize($modelResponse->getModelVersion()));
    }
}
