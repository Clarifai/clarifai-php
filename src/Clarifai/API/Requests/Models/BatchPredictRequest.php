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
use Clarifai\Internal\_Model;
use Clarifai\Internal\_MultiOutputResponse;
use Clarifai\Internal\_OutputConfig;
use Clarifai\Internal\_OutputInfo;
use Clarifai\Internal\_PostModelOutputsRequest;

class BatchPredictRequest extends ClarifaiRequest
{
    private $modelType;
    private $modelID;
    private $inputs;

    private $modelVersionID;
    /**
     * @param string $val
     * @return BatchPredictRequest
     */
    public function withModelVersionID($val) { $this->modelVersionID = $val; return $this; }

    private $language;
    /**
     * @param string $val
     * @return BatchPredictRequest
     */
    public function withLanguage($val) { $this->language = $val; return $this; }

    private $minValue;
    /**
     * @param float $val
     * @return BatchPredictRequest
     */
    public function withMinValue($val) { $this->minValue = $val; return $this; }

    private $maxConcepts;
    /**
     * @param int $val
     * @return BatchPredictRequest
     */
    public function withMaxConcepts($val) { $this->maxConcepts = $val; return $this; }

    private $selectConcepts;
    /**
     * @param Concept[] $val
     * @return BatchPredictRequest
     */
    public function withSelectConcepts($val) { $this->selectConcepts = $val; return $this; }

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     * @param ModelType $modelType The model type.
     * @param string $modelID The model ID.
     * @param ClarifaiInput[] $inputs A list of inputs to run predictions on.
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient, ModelType $modelType,
        $modelID, $inputs)
    {
        parent::__construct($httpClient);
        $this->modelType = $modelType;
        $this->modelID = $modelID;
        $this->inputs = $inputs;
    }

    protected function requestMethod()
    {
        return RequestMethod::POST;
    }

    protected function url()
    {
        return "/v2/models/$this->modelID/outputs";
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $inputs = [];
        foreach ($this->inputs as $input) {
            array_push($inputs, $input->serialize());
        }
        $postModelOutputsRequest = (new _PostModelOutputsRequest())
            ->setInputs($inputs);

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
     * @return ClarifaiOutput[]
     * @throws \Clarifai\Exceptions\ClarifaiException
     */
    protected function unmarshaller($response)
    {
        $outputs = [];
        foreach ($response->getOutputs() as $output) {
            array_push($outputs,
                ClarifaiOutput::deserialize($this->httpClient, $this->modelType, $output));
        }
        return $outputs;
    }
}
