<?php

namespace Clarifai\DTOs\Models;

use Clarifai\API\ClarifaiClientInterface;
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

    public function __construct(ClarifaiClientInterface $client, $modelID)
    {
        parent::__construct($client, $modelID);
    }

    /**
     * @param ClarifaiClientInterface $client
     * @param _Model $modelResponse
     * @return ColorModel
     */
    public static function deserializeInner(ClarifaiClientInterface $client, $modelResponse) {
        return (new ColorModel($client, $modelResponse->getId()))
            ->withName($modelResponse->getName())
            ->withCreatedAt($modelResponse->getCreatedAt()->toDateTime())
            ->withAppID($modelResponse->getAppId())
            ->withOutputInfo(ColorOutputInfo::deserialize($modelResponse->getOutputInfo()))
            ->withModelVersion(ModelVersion::deserialize($modelResponse->getModelVersion()));
    }
}
