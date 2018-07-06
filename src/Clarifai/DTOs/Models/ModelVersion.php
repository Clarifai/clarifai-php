<?php

namespace Clarifai\DTOs\Models;

use Clarifai\Internal\_ModelVersion;

class ModelVersion
{
    private $id;
    /**
     * @return string The ID of this model's version.
     */
    public function id() { return $this->id; }

    private $createdAt;
    /**
     * @return \DateTime Created at.
     */
    public function createdAt() { return $this->createdAt; }

    private $modelTrainingStatus;
    /**
     * @return ModelTrainingStatus The model's training status.
     */
    public function modelTrainingStatus() { return $this->modelTrainingStatus; }

    private $activeConceptCount;
    /**
     * @return int The number of active concepts.
     */
    public function activeConceptCount() { return $this->activeConceptCount; }

    private $totalInputCount;
    /**
     * @return int The number of all inputs.
     */
    public function totalInputCount() { return $this->totalInputCount; }

    private $modelMetricsStatus;
    /**
     * @return ModelMetricsStatus Model evaluation metrics status. Null if not available.
     */
    public function modelMetricsStatus() { return $this->modelMetricsStatus; }

    /**
     * Ctor.
     * @param string $id The ID.
     * @param \DateTime $createdAt Created at.
     * @param ModelTrainingStatus $modelTrainingStatus The model training status.
     * @param int $activeConceptCount Number of active concepts.
     * @param int $totalInputCount Number of total inputs.
     * @param ModelMetricsStatus $modelMetricsStatus The model metrics status.
     */
    public function __construct($id, $createdAt, $modelTrainingStatus, $activeConceptCount,
        $totalInputCount, $modelMetricsStatus)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->modelTrainingStatus = $modelTrainingStatus;
        $this->activeConceptCount = $activeConceptCount;
        $this->totalInputCount = $totalInputCount;
        $this->modelMetricsStatus = $modelMetricsStatus;
    }

    /**
     * @param _ModelVersion $modelVersionResponse
     * @return ModelVersion
     */
    public static function deserialize($modelVersionResponse)
    {
        if (is_null($modelVersionResponse)) {
            return null;
        }

        $modelMetricsStatus = null;
        if (!is_null($modelVersionResponse->getMetrics())) {
            $modelMetricsStatus = ModelMetricsStatus::deserialize($modelVersionResponse->getMetrics()->getStatus());
        }
        return new ModelVersion(
            $modelVersionResponse->getId(),
            $modelVersionResponse->getCreatedAt()->toDateTime(),
            ModelTrainingStatus::deserialize($modelVersionResponse->getStatus()),
            $modelVersionResponse->getActiveConceptCount(),
            $modelVersionResponse->getTotalInputCount(),
            $modelMetricsStatus);
    }
}
