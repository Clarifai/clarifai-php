<?php

namespace Clarifai\DTOs\Workflows;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\Internal\_PostWorkflowResultsResponse;

class WorkflowPredictResult
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
     * @var WorkflowResult
     */
    private $workflowResult;
    /**
     * @return WorkflowResult The workflow result.
     */
    public function workflowResult() { return $this->workflowResult; }

    public function __construct(Workflow $workflow, WorkflowResult $workflowResult)
    {
        $this->workflow = $workflow;
        $this->workflowResult = $workflowResult;
    }

    /**
     * @param ClarifaiHttpClientInterface $httpClient
     * @param _PostWorkflowResultsResponse $response
     * @return WorkflowPredictResult
     */
    public static function deserialize(ClarifaiHttpClientInterface $httpClient, $response)
    {
        return new WorkflowPredictResult(
            !is_null($response->getWorkflow())
                ? Workflow::deserialize($response->getWorkflow())
                : null,
            WorkflowResult::deserialize($httpClient, $response->getResults()[0]));
    }

}
