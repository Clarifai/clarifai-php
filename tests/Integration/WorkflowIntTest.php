<?php

namespace Integration;

use Clarifai\DTOs\Inputs\ClarifaiFileImage;
use Clarifai\DTOs\Inputs\ClarifaiFileVideo;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Inputs\ClarifaiURLVideo;
use Clarifai\DTOs\Workflows\WorkflowBatchPredictResult;
use Clarifai\DTOs\Workflows\WorkflowPredictResult;

class WorkflowIntTest extends BaseInt
{
    public function testWorkflowPredictUrlImage()
    {
        $response = $this->client->workflowPredict('food-and-general',
            new ClarifaiURLImage(parent::FOCUS_IMG_URL))
            ->executeSync();

        /** @var WorkflowPredictResult $result */
        $result = $response->get();

        $workflowResult = $result->workflowResult();
        $predictions = $workflowResult->predictions();

        $this->assertEquals(2, count($predictions));
        $this->assertNotNull($predictions[0]->id());
        $this->assertNotNull($predictions[0]->data());
        $this->assertNotNull($predictions[0]->createdAt());
        $this->assertNotNull($predictions[0]->model()->modelID());
        $this->assertNotNull($predictions[0]->status()->statusCode());

        $this->assertNotNull($predictions[1]->id());
        $this->assertNotNull($predictions[1]->data());
    }

    public function testWorkflowPredictFileImage()
    {
        $response = $this->client->workflowPredict('food-and-general',
            new ClarifaiFileImage(file_get_contents(parent::BALLOONS_FILE_PATH)))
            ->executeSync();

        /** @var WorkflowPredictResult $result */
        $result = $response->get();

        $workflowResult = $result->workflowResult();
        $predictions = $workflowResult->predictions();

        $this->assertEquals(2, count($predictions));
        $this->assertNotNull($predictions[0]->id());
        $this->assertNotNull($predictions[0]->data());
        $this->assertNotNull($predictions[0]->createdAt());
        $this->assertNotNull($predictions[0]->model()->modelID());
        $this->assertNotNull($predictions[0]->status()->statusCode());

        $this->assertNotNull($predictions[1]->id());
        $this->assertNotNull($predictions[1]->data());
    }

    public function testWorkflowBatchPredict()
    {
        $response = $this->client->workflowBatchPredict('food-and-general',
            [
                new ClarifaiURLImage(parent::FOCUS_IMG_URL)
            ])
            ->executeSync();

        /** @var WorkflowBatchPredictResult $result */
        $result = $response->get();
        $workflowResults = $result->workflowResults();
        $this->assertEquals(1, count($workflowResults));

        $predictions = $workflowResults[0]->predictions();

        $this->assertEquals(2, count($predictions));
        $this->assertNotNull($predictions[0]->id());
        $this->assertNotNull($predictions[0]->data());
        $this->assertNotNull($predictions[0]->createdAt());
        $this->assertNotNull($predictions[0]->model()->modelID());
        $this->assertNotNull($predictions[0]->status()->statusCode());

        $this->assertNotNull($predictions[1]->id());
        $this->assertNotNull($predictions[1]->data());
    }
}
