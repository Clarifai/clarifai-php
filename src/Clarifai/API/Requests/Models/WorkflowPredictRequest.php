<?php

namespace Clarifai\API\Requests\Models;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Workflows\WorkflowPredictResult;
use Clarifai\Internal\_OutputConfig;
use Clarifai\Internal\_PostWorkflowResultsRequest;
use Clarifai\Internal\_PostWorkflowResultsResponse;

class WorkflowPredictRequest extends ClarifaiRequest
{
    private $workflowID;
    private $input;

    private $minValue;
    /**
     * @param float $val
     * @return WorkflowPredictRequest
     */
    public function withMinValue($val) { $this->minValue = $val; return $this; }

    private $maxConcepts;
    /**
     * @param int $val
     * @return WorkflowPredictRequest
     */
    public function withMaxConcepts($val) { $this->maxConcepts = $val; return $this; }

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     * @param string $workflowID The workflow ID.
     * @param ClarifaiInput $input The input.
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient, $workflowID,
        ClarifaiInput $input)
    {
        parent::__construct($httpClient);
        $this->workflowID = $workflowID;
        $this->input = $input;
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
        $request = (new _PostWorkflowResultsRequest())
            ->setInputs([$this->input->serialize()]);

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
     * @return WorkflowPredictResult
     */
    protected function unmarshaller($response)
    {
        return WorkflowPredictResult::deserialize($this->httpClient, $response);
    }
}
