<?php

namespace Clarifai\DTOs\Models;

use Clarifai\Internal\Status\_Status;

class ModelMetricsStatus
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
     * The model was successfully evaluated.
     * @return ModelMetricsStatus
     */
    public static function modelEvaluated() { return new ModelMetricsStatus(21300); }

    /**
     * Model is evaluating.
     * @return ModelMetricsStatus
     */
    public static function modelEvaluating() { return new ModelMetricsStatus(21301); }

    /**
     * Model evaluation has not yet been run.
     * @return ModelMetricsStatus
     */
    public static function modelNotEvaluated() { return new ModelMetricsStatus(21302); }

    /**
     * Model is queued for evaluation.
     * @return ModelMetricsStatus
     */
    public static function modelQueuedForEvaluation() { return new ModelMetricsStatus(21303); }

    /**
     * Model evaluation timed out.
     * @return ModelMetricsStatus
     */
    public static function modelEvaluationTimedOut() { return new ModelMetricsStatus(21310); }

    /**
     * Model evaluation timed out waiting on inputs to process.
     * @return ModelMetricsStatus
     */
    public static function modelEvaluationWaitingError() { return new ModelMetricsStatus(21311); }

    /**
     * Model evaluation unknown internal error.
     * @return ModelMetricsStatus
     */
    public static function modelEvaluationUnknownError() { return new ModelMetricsStatus(21312); }

    /**
     * Model evaluation failed because there are not enough annotated inputs. Please
     * have at least 2 concepts in your model with 5 labelled inputs each before evaluating.
     * @return ModelMetricsStatus
     */
    public static function modelEvaluationNeedLabels() { return new ModelMetricsStatus(21315); }

    /**
     * @return bool true if status is an error
     */
    public function isError()
    {
        return 21310 <= $this->statusCode && $this->statusCode <= 21319;
    }

    /**
     * @return bool true if the training has stopped
     */
    public function isTerminalEvent()
    {
        return $this->isError() || $this->statusCode == $this->modelEvaluated()->statusCode();
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
     * @return ModelMetricsStatus
     */
    public static function deserialize($statusResponse)
    {
        $statusCode = $statusResponse->getCode();
        if (!(21300 <= $statusCode && $statusCode <= 21303 ||
            21310 <= $statusCode && $statusCode <= 21319)) {
            $statusCode = ModelMetricsStatus::UNKNOWN_STATUS_CODE;
        }
        return new ModelMetricsStatus($statusCode, $statusResponse->getDescription());
    }
}
