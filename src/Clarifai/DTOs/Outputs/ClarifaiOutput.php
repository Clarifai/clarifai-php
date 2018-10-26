<?php
namespace Clarifai\DTOs\Outputs;

use Clarifai\API\ClarifaiHttpClientInterface;
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
use Clarifai\DTOs\Predictions\PredictionInterface;
use Clarifai\Exceptions\ClarifaiException;
use Clarifai\Internal\_Color;
use Clarifai\Internal\_Concept;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_Embedding;
use Clarifai\Internal\_Frame;
use Clarifai\Internal\_Output;
use Clarifai\Internal\_Region;

class ClarifaiOutput
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
     * @return PredictionInterface[]
     */
    public function data() { return $this->predictions; }

    private $status;
    /**
     * @return ClarifaiStatus
     */
    public function status() { return $this->status; }

    protected function __construct($id, $createdAt, $model, $input, $predictions, $status)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->model = $model;
        $this->input = $input;
        $this->predictions = $predictions;
        $this->status = $status;
    }

    /**
     * @param ClarifaiHttpClientInterface $client
     * @param ModelType $modelType
     * @param _Output $outputResponse
     * @return ClarifaiOutput
     * @throws ClarifaiException
     */
    public static function deserialize(ClarifaiHttpClientInterface $client, ModelType $modelType,
        $outputResponse)
    {
        if (is_null($outputResponse)) {
            return new ClarifaiOutput(null, null, null, null, [], null);
        }
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

    /**
     * @param ModelType $modelType
     * @param _Output $outputResponse
     * @return PredictionInterface[]
     * @throws ClarifaiException
     */
    private static function deserializePredictions(ModelType $modelType, $outputResponse)
    {
        /** @var _Data $data */
        $data = $outputResponse->getData();

        $predictions = [];
        switch ($modelType)
        {
            case ModelType::color():
                {
                    /** @var _Color $color */
                    foreach ($data->getColors() as $color) {
                        array_push($predictions, Color::deserialize($color));
                    }
                    break;
                }
            case ModelType::concept():
                {
                    /** @var _Concept $concept */
                    foreach ($data->getConcepts() as $concept) {
                        array_push($predictions, Concept::deserialize($concept));
                    }
                    break;
                }
            case ModelType::demographics():
                {
                    /** @var _Region $demographics */
                    foreach ($data->getRegions() as $demographics) {
                        array_push($predictions, Demographics::deserialize($demographics));
                    }
                    break;
                }
            case ModelType::embedding():
                {
                    /** @var _Embedding $embedding */
                    foreach ($data->getEmbeddings() as $embedding) {
                        array_push($predictions, Embedding::deserialize($embedding));
                    }
                    break;
                }
            case ModelType::faceConcepts():
                {
                    /** @var _Region $faceConcept */
                    foreach ($data->getRegions() as $faceConcept) {
                        array_push($predictions, FaceConcepts::deserialize($faceConcept));
                    }
                    break;
                }
            case ModelType::faceDetection():
                {
                    /** @var _Region $faceDetection */
                    foreach ($data->getRegions() as $faceDetection) {
                        array_push($predictions, FaceDetection::deserialize($faceDetection));
                    }
                    break;
                }
            case ModelType::faceEmbedding():
                {
                    /** @var _Region $faceEmbedding */
                    foreach ($data->getRegions() as $faceEmbedding) {
                        array_push($predictions, FaceEmbedding::deserialize($faceEmbedding));
                    }
                    break;
                }
            case ModelType::focus():
                {
                    /** @var _Region $focus */
                    foreach ($data->getRegions() as $focus) {
                        array_push($predictions, Focus::deserialize($focus,
                            $data->getFocus()->getValue()));
                    }
                    break;
                }
            case ModelType::logo():
                {
                    /** @var _Region $logo */
                    foreach ($data->getRegions() as $logo) {
                        array_push($predictions, Logo::deserialize($logo));
                    }
                    break;
                }
            case ModelType::video():
                {
                    /** @var _Frame $frame */
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
