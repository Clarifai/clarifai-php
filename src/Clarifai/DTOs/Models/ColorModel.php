<?php

namespace Clarifai\DTOs\Models;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\DTOs\Models\OutputInfos\ColorOutputInfo;
use Clarifai\Internal\_Model;

/**
 * The color model associates inputs with the dominant colors.
 */
class ColorModel extends Model
{
    /**
     * @inheritdoc
     */
    public function type()
    {
        return ModelType::color();
    }

    /**
     * @return ColorOutputInfo The output info.
     */
    public function outputInfo() { return $this->outputInfo; }

    public function __construct(ClarifaiHttpClientInterface $httpClient, $modelID)
    {
        parent::__construct($httpClient, $modelID);
    }

    /**
     * @param ClarifaiHttpClientInterface $httpClient
     * @param _Model $modelResponse
     * @return ColorModel
     */
    public static function deserializeInner(ClarifaiHttpClientInterface $httpClient, $modelResponse) {
        return (new ColorModel($httpClient, $modelResponse->getId()))
            ->withName($modelResponse->getName())
            ->withCreatedAt($modelResponse->getCreatedAt()->toDateTime())
            ->withAppID($modelResponse->getAppId())
            ->withOutputInfo(ColorOutputInfo::deserialize($modelResponse->getOutputInfo()))
            ->withModelVersion(ModelVersion::deserialize($modelResponse->getModelVersion()));
    }
}
