<?php

namespace Clarifai\DTOs\Models;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\Requests\Models\BatchPredictRequest;
use Clarifai\API\Requests\Models\DeleteModelVersionRequest;
use Clarifai\API\Requests\Models\GetModelVersionRequest;
use Clarifai\API\Requests\Models\GetModelVersionsRequest;
use Clarifai\API\Requests\Models\PredictRequest;
use Clarifai\API\Requests\Models\TrainModelRequest;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Models\OutputInfos\OutputInfoInterface;
use Clarifai\Exceptions\ClarifaiException;
use Clarifai\Internal\_Model;

abstract class Model
{
    private $httpClient;

    private $modelID;
    /**
     * @return string The model ID.
     */
    public function modelID() { return $this->modelID; }

    private $name;
    /**
     * @return string The model name.
     */
    public function name() { return $this->name; }
    public function withName($val) { $this->name = $val; return $this; }

    private $createdAt;
    /**
     * @return \DateTime Created at.
     */
    public function createdAt() { return $this->createdAt; }
    public function withCreatedAt(\DateTime $val) { $this->createdAt = $val; return $this; }

    private $appID;
    /**
     * @return string The app ID.
     */
    public function appID() { return $this->appID; }
    public function withAppID($val) { $this->appID = $val; return $this; }

    private $modelVersion;
    /**
     * @return ModelVersion The model version.
     */
    public function modelVersion() { return $this->modelVersion; }
    public function withModelVersion(ModelVersion $val)
    { $this->modelVersion = $val; return $this; }

    protected $outputInfo;
    /**
     * @return OutputInfoInterface The output info.
     */
    public function outputInfo() { return $this->outputInfo; }
    public function withOutputInfo(OutputInfoInterface $val)
    { $this->outputInfo = $val; return $this; }

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai client.
     * @param string $modelID The model ID.
     */
    protected function __construct(ClarifaiHttpClientInterface $httpClient, $modelID)
    {
        $this->httpClient = $httpClient;
        $this->modelID = $modelID;
    }

    /**
     * Deserializes the model to a correct object instance.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai client.
     * @param ModelType $type The prediction type.
     * @param _Model $model The model object.
     * @return Model The deserialized model.
     * @throws ClarifaiException Thrown if unknown model type.
     */
    public static function deserialize(ClarifaiHttpClientInterface $httpClient, $type, $model)
    {
        switch ($type) {
            case ModelType::color():
                return ColorModel::deserializeInner($httpClient, $model);
            case ModelType::concept():
                return ConceptModel::deserializeInner($httpClient, $model);
            case ModelType::demographics():
                return DemographicsModel::deserializeInner($httpClient, $model);
            case ModelType::embedding():
                return EmbeddingModel::deserializeInner($httpClient, $model);
            case ModelType::faceConcepts():
                return FaceConceptsModel::deserializeInner($httpClient, $model);
            case ModelType::faceDetection():
                return FaceDetectionModel::deserializeInner($httpClient, $model);
            case ModelType::faceEmbedding():
                return FaceEmbeddingModel::deserializeInner($httpClient, $model);
            case ModelType::focus():
                return FocusModel::deserializeInner($httpClient, $model);
            case ModelType::logo():
                return LogoModel::deserializeInner($httpClient, $model);
            case ModelType::video():
                return VideoModel::deserializeInner($httpClient, $model);
            default:
                throw new ClarifaiException("Unknown model type: {$type->typeExt()}");
        }
    }

    public static function deserializeJson(ClarifaiHttpClientInterface $client, $type, $jsonObject)
    {
        // Only concept model is currently supported in moderation solution.
        return ConceptModel::deserializeJsonInner($client, $jsonObject);
    }

    /**
     * @return ModelType The model type.
     */
    public abstract function type();

    /**
     * @return TrainModelRequest A new instance.
     */
    public function train()
    {
        return new TrainModelRequest($this->httpClient, $this->type(), $this->modelID);
    }

    /**
     * Returns a request for retrieving a specific model version.
     *
     * @param string $modelVersionID The model version ID.
     * @return GetModelVersionRequest A new instance.
     */
    public function getModelVersion($modelVersionID)
    {
        return new GetModelVersionRequest($this->httpClient, $this->modelID, $modelVersionID);
    }

    /**
     * Returns a request for retrieving all model versions.
     *
     * @return GetModelVersionsRequest A new instance.
     */
    public function getModelVersions()
    {
        return new GetModelVersionsRequest($this->httpClient, $this->modelID);
    }

    /**
     * Returns a request for deleting a specific model version. To delete the current model
     * version, set the argument to $yourModel->modelVersion->id().
     *
     * @param string $modelVersionID The model version ID.
     * @return DeleteModelVersionRequest
     */
    public function deleteModelVersion($modelVersionID)
    {
        return new DeleteModelVersionRequest($this->httpClient, $this->modelID, $modelVersionID);
    }


    /**
     * Runs a prediction on an input using this Model.
     *
     * @param ClarifaiInput $input The input.
     * @return PredictRequest A new instance.
     */
    public function predict($input)
    {
        return new PredictRequest($this->httpClient, $this->type(), $this->modelID, $input);
    }

    /**
     * Runs a prediction on multiple inputs using this Model.
     *
     * @param ClarifaiInput[] $inputs The inputs.
     * @return BatchPredictRequest A new instance.
     */
    public function batchPredict($inputs)
    {
        return new BatchPredictRequest($this->httpClient, $this->type(), $this->modelID, $inputs);
    }
}
