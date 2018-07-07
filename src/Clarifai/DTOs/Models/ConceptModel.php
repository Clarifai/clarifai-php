<?php

namespace Clarifai\DTOs\Models;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\DTOs\Models\OutputInfos\ConceptOutputInfo;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_Model;
use Clarifai\Internal\_OutputConfig;
use Clarifai\Internal\_OutputInfo;
use Google\Protobuf\Timestamp;

/**
 * The concept model associates inputs with concepts. Users can train their own concept models and
 * use them for prediction.
 */
class ConceptModel extends Model
{
    /**
     * @inheritdoc
     */
    public function type()
    {
        return ModelType::concept();
    }

    /**
     * @return ConceptOutputInfo The output info.
     */
    public function outputInfo() { return $this->outputInfo; }

    /**
     * Ctor.
     * @param ClarifaiClientInterface $client The Clarifai client.
     * @param string $modelID The model ID.
     */
    public function __construct(ClarifaiClientInterface $client, $modelID)
    {
        parent::__construct($client, $modelID);
    }

    /**
     * Serializes the concept model to an array.
     * @param Concept[] $concepts The concepts.
     * @param bool $areConceptsMutuallyExclusive Are the concepts mutually exclusive.
     * @param bool $isEnvironmentClosed Is environment closed.
     * @param string $language The language.
     * @return _Model Serialized concept model.
     */
    public function serialize($concepts, $areConceptsMutuallyExclusive, $isEnvironmentClosed,
        $language)
    {
        $model = (new _Model())->setId($this->modelID());
        if (!is_null($this->name())) {
            $model->setName($this->name());
        }
        if (!is_null($this->appID())) {
            $model->setAppId($this->appID());
        }
        if (!is_null($this->createdAt())) {
            $dt = new Timestamp();
            $dt->fromDateTime($this->createdAt());
            $model->setCreatedAt($dt);
        }

        $hasAnyOutputInfo = false;
        $outputInfo = new _OutputInfo();
        if (!is_null($concepts)) {
            $serializedConcepts = [];
            foreach ($concepts as $concept) {
                array_push($serializedConcepts, $concept->serialize());
            }
            $outputInfo->setData((new _Data())->setConcepts($serializedConcepts));
            $hasAnyOutputInfo = true;
        }

        $hasAnyOutputConfig = false;
        $outputConfig = new _OutputConfig();
        if ($areConceptsMutuallyExclusive) {
            $outputConfig->setConceptsMutuallyExclusive($areConceptsMutuallyExclusive);
            $hasAnyOutputConfig = true;
        }
        if ($isEnvironmentClosed) {
            $outputConfig->setClosedEnvironment($isEnvironmentClosed);
            $hasAnyOutputConfig = true;
        }
        if (!is_null($language)) {
            $outputConfig->setLanguage($language);
            $hasAnyOutputConfig = true;
        }

        if ($hasAnyOutputConfig) {
            $outputInfo->setOutputConfig($outputConfig);
            $hasAnyOutputInfo = true;
        }

        if ($hasAnyOutputInfo) {
            $model->setOutputInfo($outputInfo);
        }

        return $model;
    }

    /**
     * @param ClarifaiClientInterface $client
     * @param _Model $modelResponse
     * @return ConceptModel
     */
    public static function deserializeInner(ClarifaiClientInterface $client, $modelResponse) {
        return (new ConceptModel($client, $modelResponse->getId()))
            ->withName($modelResponse->getName())
            ->withCreatedAt($modelResponse->getCreatedAt()->toDateTime())
            ->withAppID($modelResponse->getAppId())
            ->withOutputInfo(ConceptOutputInfo::deserialize($modelResponse->getOutputInfo()))
            ->withModelVersion(ModelVersion::deserialize($modelResponse->getModelVersion()));
    }
}
