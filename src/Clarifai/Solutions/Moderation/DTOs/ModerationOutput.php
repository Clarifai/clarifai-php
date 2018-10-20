<?php

namespace Clarifai\Solutions\Moderation\DTOs;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\DTOs\ClarifaiStatus;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Models\Model;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Helpers\DateTimeHelper;

class ModerationOutput
{
    private $id;
    /**
     * @return string
     */
    public function id() { return $this->id; }

    private $createdAt;
    /**
     * @return \DateTime
     */
    public function createdAt() { return $this->createdAt; }

    private $model;
    /**
     * @return Model
     */
    public function model() { return $this->model; }

    private $input;
    /**
     * @return ClarifaiInput
     */
    public function input() { return $this->input; }

    private $predictions;
    /**
     * @return Concept[]
     */
    public function data() { return $this->predictions; }

    private $status;
    /**
     * @return ClarifaiStatus
     */
    public function status() { return $this->status; }

    private $moderationStatus;
    /**
     * @return ModerationStatus
     */
    public function moderationStatus() { return $this->moderationStatus; }

    /**
     * Ctor.
     * @param string $id
     * @param \DateTime $createdAt
     * @param Model $model
     * @param ClarifaiInput $input
     * @param Concept[] $predictions
     * @param ClarifaiStatus $status
     * @param ModerationStatus $moderationStatus
     */
    protected function __construct($id, $createdAt, $model, $input, $predictions, $status,
        $moderationStatus)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->model = $model;
        $this->input = $input;
        $this->predictions = $predictions;
        $this->status = $status;
        $this->moderationStatus = $moderationStatus;
    }

    /**
     * @param ClarifaiHttpClientInterface $httpClient
     * @param array $jsonObject
     * @return ModerationOutput
     */
    public static function deserialize(ClarifaiHttpClientInterface $httpClient, $jsonObject)
    {
        $data = $jsonObject['data'];

        $predictions = [];
        if (count($data) > 0)
        {
            foreach ($data['concepts'] as $concept) {
                array_push($predictions, Concept::deserializeJson($concept));
            }
        }

        return new ModerationOutput(
            $jsonObject['id'],
            DateTimeHelper::parseDateTime($jsonObject['created_at']),
            Model::deserializeJson($httpClient, ModelType::concept(), $jsonObject['model']),
            ClarifaiInput::deserializeJson($jsonObject['input']),
            $predictions,
            ClarifaiStatus::deserializeJson($jsonObject['status']),
            ModerationStatus::deserializeJson($jsonObject['moderation']['status'])
        );
    }
}
