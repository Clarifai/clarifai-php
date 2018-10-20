<?php

namespace Clarifai\API\Requests\Models;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Workflows\WorkflowBatchPredictResult;
use Clarifai\Internal\_OutputConfig;
use Clarifai\Internal\_PostWorkflowResultsRequest;
use Clarifai\Internal\_PostWorkflowResultsResponse;

class WorkflowBatchPredictRequest extends ClarifaiRequest
{
    private $workflowID;
    private $inputs;

    private $minValue;
    /**
     * @param float $val
     * @return WorkflowBatchPredictRequest
     */
    public function withMinValue($val) { $this->minValue = $val; return $this; }

    private $maxConcepts;
    /**
     * @param int $val
     * @return WorkflowBatchPredictRequest
     */
    public function withMaxConcepts($val) { $this->maxConcepts = $val; return $this; }

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     * @param string $workflowID
     * @param ClarifaiInput[] $inputs
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient, $workflowID, $inputs)
    {
        parent::__construct($httpClient);
        $this->workflowID = $workflowID;
        $this->inputs = $inputs;
    }

    protected function requestMethod()
    {
        return RequestMethod::POST;
    }

    protected function url()
    {
        return "/v2/workflows/$this->workflowID/results";
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $inputs = [];
        foreach ($this->inputs as $input) {
            array_push($inputs, $input->serialize());
        }
        $request = (new _PostWorkflowResultsRequest())
            ->setInputs($inputs);

        $outputConfig = (new _OutputConfig());
        $anyOutputConfig = false;
        if (!is_null($this->minValue)) {
            $outputConfig->setMinValue($this->minValue);
            $anyOutputConfig = true;
        }
        if (!is_null($this->maxConcepts)) {
            $outputConfig->setMaxConcepts($this->maxConcepts);
            $anyOutputConfig = true;
        }
        if ($anyOutputConfig) {
            $request->setOutputConfig($outputConfig);
        }

        return $grpcClient->PostWorkflowResults($request);
    }

    /**
     * @param _PostWorkflowResultsResponse $response
     * @return WorkflowBatchPredictResult
     */
    protected function unmarshaller($response)
    {
        return WorkflowBatchPredictResult::deserialize($this->httpClient, $response);
    }
}
