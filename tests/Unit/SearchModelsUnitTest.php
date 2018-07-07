<?php

namespace Unit;

use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Models\Model;
use Clarifai\DTOs\Models\ModelType;
use PHPUnit\Framework\TestCase;

class SearchModelsUnitTest extends TestCase
{
    public function testSearchModelsByName()
    {
        $postResponse = <<<EOD
{
    "status": {
        "code": 10000,
        "description": "Ok"
    },
    "models": [{
        "id": "@modelID",
        "name": "celeb-v1.3",
        "created_at": "2016-10-25T19:30:38.541073Z",
        "app_id": "main",
        "output_info": {
            "message": "Show output_info with: GET /models/{model_id}/output_info",
            "type": "concept",
            "type_ext": "facedetect-identity"
        },
        "model_version": {
            "id": "@modelVersionID",
            "created_at": "2016-10-25T19:30:38.541073Z",
            "status": {
                "code": 21100,
                "description": "Model trained successfully"
            },
            "active_concept_count": 10554
        },
        "display_name": "Celebrity"
    }]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);

        $response = $client->searchModels('celeb*')
            ->executeSync();

        $expectedRequestBody = <<<EOD
{
    "model_query": {
      "name": "celeb*"
    }
}
EOD;

        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());
        $this->assertTrue($response->isSuccessful());

        /** @var Model[] $searchInputsResult */
        $models = $response->get();

        $this->assertEquals(1, count($models));

        $this->assertEquals('@modelID', $models[0]->modelID());
        $this->assertEquals('@modelVersionID', $models[0]->modelVersion()->id());
    }

    public function testSearchModelsByNameAndType()
    {
        $postResponse = <<<EOD
{
    "status": {
        "code": 10000,
        "description": "Ok"
    },
    "models": [{
        "id": "@modelID",
        "name": "focus",
        "created_at": "2017-03-06T22:57:00.660603Z",
        "app_id": "main",
        "output_info": {
            "message": "Show output_info with: GET /models/{model_id}/output_info",
            "type": "blur",
            "type_ext": "focus"
        },
        "model_version": {
            "id": "@modelVersionID",
            "created_at": "2017-03-06T22:57:00.684652Z",
            "status": {
                "code": 21100,
                "description": "Model trained successfully"
            }
        },
        "display_name": "Focus"
    }]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);

        $response = $client->searchModels('*', ModelType::focus())
            ->executeSync();

        $expectedRequestBody = <<<EOD
{
    "model_query": {
      "name": "*",
      "type": "focus"
    }
}
EOD;

        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());
        $this->assertTrue($response->isSuccessful());

        /** @var Model[] $searchInputsResult */
        $models = $response->get();

        $this->assertEquals(1, count($models));

        $this->assertEquals('@modelID', $models[0]->modelID());
        $this->assertEquals('@modelVersionID', $models[0]->modelVersion()->id());
    }
}
