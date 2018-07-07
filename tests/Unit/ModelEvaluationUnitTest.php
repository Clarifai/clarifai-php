<?php

namespace Unit;

use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Models\ModelVersion;
use PHPUnit\Framework\TestCase;

class ModelEvaluationUnitTest extends TestCase
{
    public function testModelEvaluation()
    {
        $postResponse = <<<EOD
{
    "status": {
        "code": 10000,
        "description": "Ok"
    },
    "model_version": {
        "id": "@versionID",
        "created_at": "2017-01-01T00:00:00.000000Z",
        "status": {
            "code": 21100,
            "description": "Model trained successfully"
        },
        "active_concept_count": 2,
        "metrics": {
            "status": {
                "code": 21303,
                "description": "Model is queued for evaluation."
            }
        },
        "total_input_count": 30
    }
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->modelEvaluation('@modelID', '@versionID')
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        $this->assertEquals('Ok', $response->status()->description());

        /** @var ModelVersion $modelVersion */
        $modelVersion = $response->get();
        $this->assertEquals('@versionID', $modelVersion->id());
        $this->assertEquals(21100, $modelVersion->modelTrainingStatus()->statusCode());
        $this->assertEquals('Model trained successfully',
            $modelVersion->modelTrainingStatus()->description());
        $this->assertEquals(21303, $modelVersion->modelMetricsStatus()->statusCode());
        $this->assertEquals(2, $modelVersion->activeConceptCount());
        $this->assertEquals(30, $modelVersion->totalInputCount());
    }
}
