<?php

namespace Clarifai\DTOs\Workflows;

use Clarifai\DTOs\ClarifaiStatus;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Outputs\ClarifaiOutput;
use Clarifai\Internal\_Output;
use Clarifai\Internal\_WorkflowResult;

class WorkflowResult
{
    /**
     * @var ClarifaiStatus
     */
    private $status;
    /**
     * @return ClarifaiStatus The status.
     */
    public function status() { return $this->status; }

    /**
     * @var ClarifaiInput
     */
    private $input;
    /**
     * @return ClarifaiInput The input.
     */
    public function input() { return $this->input; }

    /**
     * @var ClarifaiOutput[]
     */
    private $predictions;
    /**
     * @return ClarifaiOutput[] The outputs.
     */
    public function predictions() { return $this->predictions; }

    /**
     * Ctor.
     * @param ClarifaiStatus $status
     * @param ClarifaiInput $input
     * @param ClarifaiOutput[] $predictions
     */
    private function __construct($status, $input, $predictions)
    {
        $this->status = $status;
        $this->input = $input;
        $this->predictions = $predictions;
    }

    /**
     * @param _WorkflowResult $workflowResultResponse
     */
    public static function deserialize($workflowResultResponse)
    {
        $status = ClarifaiStatus::deserialize($workflowResultResponse->getStatus());
        $input = ClarifaiInput::deserialize($workflowResultResponse->getInput());

        $predictions = [];
        foreach ($workflowResultResponse->getOutputs() as $output) {
            /* @var _Output $output */
            $model = $output->getModel();
            $modelType = ModelType::determineModelType($model->getOutputInfo()->getTypeExt());

            array_push($predictions,
                ClarifaiOutput::deserialize($modelType, $output));
        }

        return new WorkflowResult($status, $input, $predictions);
    }
}
