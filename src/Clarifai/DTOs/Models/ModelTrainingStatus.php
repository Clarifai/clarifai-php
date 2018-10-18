<?php

namespace Clarifai\DTOs\Models;

use Clarifai\Internal\Status\_Status;

/**
 * The current status of a model.
 */
class ModelTrainingStatus
{
    const UNKNOWN_STATUS_CODE = -1;

    private $statusCode;

    /**
     * @return int the status code
     */
    public function statusCode() { return $this->statusCode; }

    private $description;
    /**
     * @return string the description
     */
    public function description() { return $this->description; }

    /**
     * Ctor.
     * @param int $statusCode the status code
     * @param string $description the description
     */
    private function __construct($statusCode, $description = "")
    {
        $this->statusCode = $statusCode;
        $this->description = $description;
    }

    /**
     * This model has been trained.
     * @return ModelTrainingStatus
     */
    public static function trained() { return new ModelTrainingStatus(21100); }

    /**
     * This model is currently being trained by the server.
     * @return ModelTrainingStatus
     */
    public static function trainingInProgress() { return new ModelTrainingStatus(21101); }

    /**
     * This model hasn't been trained yet.
     * @return ModelTrainingStatus
     */
    public static function notYetTrained() { return new ModelTrainingStatus(21102); }

    /**
     * This model is in the queue to be trained by the server.
     * @return ModelTrainingStatus
     */
    public static function trainingQueued() { return new ModelTrainingStatus(21103); }

    /**
     * Model training had no data.
     * @return ModelTrainingStatus
     */
    public static function modelTrainingNoData() { return new ModelTrainingStatus(21110); }

    /**
     * There are no positive examples for this model, so it cannot be trained. Please add at
     * least one positive example for each of the model's concepts before trying to train it.
     * @return ModelTrainingStatus
     */
    public static function noPositiveExamples() { return new ModelTrainingStatus(21111); }

    /**
     * Custom model training was ONE_VS_N but with a single class.
     * @return ModelTrainingStatus
     */
    public static function modelTrainingOneVsNSingleClass()
    {
        return new ModelTrainingStatus(21112);
    }

    /**
     * Training took longer than the server allows.
     * @return ModelTrainingStatus
     */
    public static function modelTrainingTimedOut() { return new ModelTrainingStatus(21113); }

    /**
     * Training got error waiting on asset pipeline to finish.
     * @return ModelTrainingStatus
     */
    public static function modelTrainingWaitingError() { return new ModelTrainingStatus(21114); }

    /**
     * Training threw an unknown error.
     * @return ModelTrainingStatus
     */
    public static function modelTrainingUnknownError() { return new ModelTrainingStatus(21115); }

    /**
     * @return bool true if status is an error
     */
    public function isError()
    {
        return 21110 <= $this->statusCode && $this->statusCode <= 21119;
    }

    /**
     * @return bool true if the training has stopped
     */
    public function isTerminalEvent()
    {
        return $this->isError() || $this->statusCode == $this->trained()->statusCode();
    }

    /**
     * @return bool true if the status code wasn't recognized by the client
     */
    public function isUnknown()
    {
        return $this->statusCode == $this::UNKNOWN_STATUS_CODE;
    }

    /**
     * @param _Status $statusResponse
     * @return ModelTrainingStatus
     */
    public static function deserialize($statusResponse)
    {
        return self::innerDeserialize(
            $statusResponse->getCode(), $statusResponse->getDescription()
        );
    }

    /**
     * @param array $jsonObject
     * @return ModelTrainingStatus
     */
    public static function deserializeJson($jsonObject)
    {
        return self::innerDeserialize($jsonObject['code'], $jsonObject['description']);
    }

    /**
     * @param $statusCode
     * @param $description
     * @return ModelTrainingStatus
     */
    private static function innerDeserialize($statusCode, $description): ModelTrainingStatus
    {
        if (!(21100 <= $statusCode && $statusCode <= 21103 ||
            21110 <= $statusCode && $statusCode <= 21115)) {
            $statusCode = ModelTrainingStatus::UNKNOWN_STATUS_CODE;
        }
        return new ModelTrainingStatus($statusCode, $description);
    }

    public function __toString()
    {
        return $this->statusCode . ': ' . $this->description;
    }
}
