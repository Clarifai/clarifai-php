<?php

namespace Clarifai\DTOs\Workflows;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\Internal\_PostWorkflowResultsResponse;
use Clarifai\Internal\_WorkflowResult;

class WorkflowBatchPredictResult
{

    /**
     * @var Workflow
     */
    private $workflow;
    /**
     * @return Workflow The workflow.
     */
    public function workflow() { return $this->workflow; }

    /**
     * @var WorkflowResult[]
     */
    private $workflowResults;
    /**
     * @return WorkflowResult[] The workflow results.
     */
    public function workflowResults() { return $this->workflowResults; }

    /**
     * Ctor.
     * @param Workflow $workflow
     * @param WorkflowResult[] $workflowResults
     */
    public function __construct(Workflow $workflow, $workflowResults)
    {
        $this->workflow = $workflow;
        $this->workflowResults = $workflowResults;
    }

    /**
     * @param ClarifaiHttpClientInterface $httpClient
     * @param _PostWorkflowResultsResponse $response
     * @return WorkflowBatchPredictResult
     */
    public static function deserialize($httpClient, $response)
    {
        $workflowResults = [];
        /** @var _WorkflowResult $result */
        foreach ($response->getResults() as $result) {
            $workflowResult = WorkflowResult::deserialize($httpClient, $result);
            array_push($workflowResults, $workflowResult);
        }

        return new WorkflowBatchPredictResult(
            !is_null($response->getWorkflow())
                ? Workflow::deserialize($response->getWorkflow())
                : null,
            $workflowResults);
    }

}
