<?php
namespace Clarifai\DTOs\Outputs;

use Clarifai\API\ClarifaiClient;
use Clarifai\API\ClarifaiClientInterface;
use Clarifai\DTOs\ClarifaiStatus;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Models\Model;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Predictions\Color;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\DTOs\Predictions\Demographics;
use Clarifai\DTOs\Predictions\Embedding;
use Clarifai\DTOs\Predictions\FaceConcepts;
use Clarifai\DTOs\Predictions\FaceDetection;
use Clarifai\DTOs\Predictions\FaceEmbedding;
use Clarifai\DTOs\Predictions\Focus;
use Clarifai\DTOs\Predictions\Frame;
use Clarifai\DTOs\Predictions\Logo;
use Clarifai\Exceptions\ClarifaiException;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_Output;

class ClarifaiOutput
{
    private $id;
    private $createdAt;
    private $model;
    private $input;
    private $predictions;
    private $status;

    protected function __construct($id, $createdAt, $model, $input, $predictions, $status)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->model = $model;
        $this->input = $input;
        $this->predictions = $predictions;
        $this->status = $status;
    }

    public function id()
    {
        return $this->id;
    }

    public function createdAt() {
        return $this->createdAt;
    }

    public function model() {
        return $this->model;
    }

    public function input() {
        return $this->input;
    }

    public function data() {
        return $this->predictions;
    }

    public function status() {
        return $this->status;
    }

    /**
     * @param ClarifaiClientInterface $client
     * @param ModelType $modelType
     * @param _Output $outputResponse
     * @return ClarifaiOutput
     * @throws ClarifaiException
     */
    public static function deserialize(ClarifaiClientInterface $client, ModelType $modelType,
        $outputResponse)
    {
        return new ClarifaiOutput(
            $outputResponse->getId(),
            $outputResponse->getCreatedAt()->toDateTime(),
            Model::deserialize($client, $modelType, $outputResponse->getModel()),
            $outputResponse->getInput() ?
                ClarifaiInput::deserialize($outputResponse->getInput()) :
                null,
            self::deserializePredictions($modelType, $outputResponse),
            ClarifaiStatus::deserialize($outputResponse->getStatus())
        );
    }

    private static function deserializePredictions(ModelType $modelType, $outputResponse)
    {
        /** @var _Data $data */
        $data = $outputResponse->getData();

        $predictions = [];
        switch ($modelType)
        {
            case ModelType::color():
                {
                    foreach ($data->getColors() as $color) {
                        array_push($predictions, Color::deserialize($color));
                    }
                    break;
                }
            case ModelType::concept():
                {
                    foreach ($data->getConcepts() as $concept) {
                        array_push($predictions, Concept::deserialize($concept));
                    }
                    break;
                }
            case ModelType::demographics():
                {
                    foreach ($data->getRegions() as $demographics) {
                        array_push($predictions, Demographics::deserialize($demographics));
                    }
                    break;
                }
            case ModelType::embedding():
                {
                    foreach ($data->getEmbeddings() as $embedding) {
                        array_push($predictions, Embedding::deserialize($embedding));
                    }
                    break;
                }
            case ModelType::faceConcepts():
                {
                    foreach ($data->getRegions() as $faceConcept) {
                        array_push($predictions, FaceConcepts::deserialize($faceConcept));
                    }
                    break;
                }
            case ModelType::faceDetection():
                {
                    foreach ($data->getRegions() as $faceDetection) {
                        array_push($predictions, FaceDetection::deserialize($faceDetection));
                    }
                    break;
                }
            case ModelType::faceEmbedding():
                {
                    foreach ($data->getRegions() as $faceEmbedding) {
                        array_push($predictions, FaceEmbedding::deserialize($faceEmbedding));
                    }
                    break;
                }
            case ModelType::focus():
                {
                    foreach ($data->getRegions() as $focus) {
                        array_push($predictions, Focus::deserialize($focus,
                            $data->getFocus()->getValue()));
                    }
                    break;
                }
            case ModelType::logo():
                {
                    foreach ($data->getRegions() as $logo) {
                        array_push($predictions, Logo::deserialize($logo));
                    }
                    break;
                }
            case ModelType::video():
                {
                    foreach ($data->getFrames() as $frame) {
                        array_push($predictions, Frame::deserialize($frame));
                    }
                    break;
                }
            default:
                {
                    throw new ClarifaiException("Unknown model type: {$modelType->typeExt()}");
                }
        }
        return $predictions;
    }
}
