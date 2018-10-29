<?php
namespace Clarifai\API\Requests\Models;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Outputs\ClarifaiOutput;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Exceptions\ClarifaiException;
use Clarifai\Internal\_Model;
use Clarifai\Internal\_MultiOutputResponse;
use Clarifai\Internal\_Output;
use Clarifai\Internal\_OutputConfig;
use Clarifai\Internal\_OutputInfo;
use Clarifai\Internal\_PostModelOutputsRequest;

/**
 * Predicts on an input (image/video) using a certain model.
 */
class PredictRequest extends ClarifaiRequest
{
    /** @var string */
    private $modelID;
    /** @var ModelType */
    private $modelType;
    /** @var ClarifaiInput */
    private $input;

    /** @var string */
    private $modelVersionID;
    /**
     * @param string $val The model version ID.
     * @return PredictRequest
     */
    public function withModelVersionID($val) { $this->modelVersionID = $val; return $this; }

    /** @var string */
    private $language;
    /**
     * @param string $val The language.
     * @return PredictRequest
     */
    public function withLanguage($val) { $this->language = $val; return $this; }

    /** @var float */
    private $minValue;
    /**
     * @param float $val Only return concepts with value greater or equal.
     * @return PredictRequest
     */
    public function withMinValue($val) { $this->minValue = $val; return $this; }

    /** @var int */
    private $maxConcepts;
    /**
     * @param int $val Filter the number of concepts returned, ordered by value descending.
     * @return PredictRequest
     */
    public function withMaxConcepts($val) { $this->maxConcepts = $val; return $this; }

    /**
     * @var Concept[]
     */
    private $selectConcepts;
    /**
     * @param Concept[] $val Predict only using these concepts.
     * @return PredictRequest
     */
    public function withSelectConcepts($val) { $this->selectConcepts = $val; return $this; }

    /** @var int */
    private $sampleMs;
    /**
     * @param int $val (video only) Milliseconds span of each frame for which prediction is run.
     * @return $this
     */
    public function withSampleMs($val) { $this->sampleMs = $val; return $this; }

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     * @param ModelType $modelType The model type.
     * @param string $modelID The model ID.
     * @param ClarifaiInput $input The input.
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient, ModelType $modelType,
        $modelID, ClarifaiInput $input)
    {
        parent::__construct($httpClient);
        $this->modelID = $modelID;
        $this->modelType = $modelType;
        $this->input = $input;
    }

    protected function requestMethod()
    {
        return RequestMethod::POST;
    }

    protected function url()
    {
        if ($this->modelVersionID == null) {
            return "/v2/models/$this->modelID/outputs";
        } else {
            return "/v2/models/$this->modelID/versions/$this->modelVersionID/outputs";
        }
    }

    public function httpRequestBody(CustomV2Client $grpcClient) {
        $postModelOutputsRequest = (new _PostModelOutputsRequest())
            ->setInputs([$this->input->serialize()]);

        $outputConfig = (new _OutputConfig());
        $anyOutputConfig = false;

        if (!is_null($this->language)) {
            $outputConfig->setLanguage($this->language);
            $anyOutputConfig = true;
        }
        if (!is_null($this->minValue)) {
            $outputConfig->setMinValue($this->minValue);
            $anyOutputConfig = true;
        }
        if (!is_null($this->maxConcepts)) {
            $outputConfig->setMaxConcepts($this->maxConcepts);
            $anyOutputConfig = true;
        }
        if (!is_null($this->language)) {
            $outputConfig->setLanguage($this->language);
            $anyOutputConfig = true;
        }
        if (!is_null($this->sampleMs)) {
            $outputConfig->setSampleMs($this->sampleMs);
            $anyOutputConfig = true;
        }
        if (!is_null($this->selectConcepts)) {
            $selectConcepts = [];
            foreach ($this->selectConcepts as $selectConcept) {
                array_push($selectConcepts, $selectConcept->serialize());
            }
            $outputConfig->setSelectConcepts($selectConcepts);
            $anyOutputConfig = true;
        }


        if ($anyOutputConfig) {
            $postModelOutputsRequest
                ->setModel((new _Model())
                    ->setOutputInfo((new _OutputInfo())
                        ->setOutputConfig($outputConfig)));
        }
        return $grpcClient->PostModelOutputs($postModelOutputsRequest);
    }

    /**
     * @param _MultiOutputResponse $response
     * @return ClarifaiOutput Our serialized object.
     * @throws ClarifaiException
     */
    public function unmarshaller($response) {

        if (is_null($response->getOutputs()) || count($response->getOutputs()) === 0) {
            return ClarifaiOutput::deserialize($this->httpClient, $this->modelType, null);
        }
        $outputResponse = null;
        if (!is_null($response->getOutputs())) {
            /** @var _Output $outputResponse */
            $outputResponse = $response->getOutputs()[0];
        }
        return ClarifaiOutput::deserialize($this->httpClient, $this->modelType, $outputResponse);
    }
}
