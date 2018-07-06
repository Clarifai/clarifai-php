<?php
namespace Clarifai\API\Requests\Models;

use Clarifai\API\ClarifaiClientInterface;
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
use Clarifai\Internal\_OutputConfig;
use Clarifai\Internal\_OutputInfo;
use Clarifai\Internal\_PostModelOutputsRequest;

/**
 * Predicts on an input (image/video) using a certain model.
 */
class PredictRequest extends ClarifaiRequest
{
    private $modelID;
    private $modelType;
    private $input;

    private $modelVersionID;
    /**
     * @param string $val
     * @return PredictRequest
     */
    public function withModelVersionID($val) { $this->modelVersionID = $val; return $this; }

    private $language;
    /**
     * @param string $val
     * @return PredictRequest
     */
    public function withLanguage($val) { $this->language = $val; return $this; }

    private $minValue;
    /**
     * @param float $val
     * @return PredictRequest
     */
    public function withMinValue($val) { $this->minValue = $val; return $this; }

    private $maxConcepts;
    /**
     * @param int $val
     * @return PredictRequest
     */
    public function withMaxConcepts($val) { $this->maxConcepts = $val; return $this; }

    private $selectConcepts;
    /**
     * @param Concept[] $val
     * @return PredictRequest
     */
    public function withSelectConcepts($val) { $this->selectConcepts = $val; return $this; }

    public function __construct(ClarifaiClientInterface $client, ModelType $modelType, $modelID,
        ClarifaiInput $input)
    {
        parent::__construct($client);
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

        $outputResponses = $response->getOutputs();
        if ($outputResponses != null && count($outputResponses) === 1) {
            $outputResponse = $outputResponses[0];
            return ClarifaiOutput::deserialize($this->modelType, $outputResponse);
        }
        throw new ClarifaiException('There should be a single output.');
    }
}
