<?php

namespace Unit;

use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Inputs\ModifyAction;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Predictions\Concept;
use PHPUnit\Framework\TestCase;

class ModelUnitTest extends TestCase
{
    public function testGetModel()
    {
        $getResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "model": {
    "id": "@modelID",
    "name": "@modelName",
    "created_at": "2018-03-14T16:00:18.354154Z",
    "app_id": "@appID",
    "output_info": {
      "output_config": {
        "concepts_mutually_exclusive": false,
        "closed_environment": false
      },
      "type": "concept",
      "type_ext": "concept"
    },
    "model_version": {
      "id": "@modelVersionID",
      "created_at": "2018-03-14T16:00:18.369779Z",
      "status": {
        "code": 21102,
        "description": "Model not yet trained"
      }
    }
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getModel(ModelType::concept(), '@modelID')->executeSync();
        $this->assertTrue($response->isSuccessful());

        $model = $response->get();
        $this->assertEquals('@modelID', $model->modelID());
        $this->assertEquals('@modelName', $model->name());
        $this->assertEquals('@appID', $model->appID());
        $this->assertEquals('@appID', $model->appID());
        $this->assertEquals('@modelVersionID', $model->modelVersion()->id());

    }

    public function testCreateModel()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "model": {
    "id": "@modelID",
    "name": "@modelName",
    "created_at": "2018-03-14T15:33:58.682751084Z",
    "app_id": "@appID",
    "output_info": {
      "output_config": {
        "concepts_mutually_exclusive": false,
        "closed_environment": false
      },
      "message": "Show output_info with: GET /models/{model_id}/output_info",
      "type": "concept",
      "type_ext": "concept"
    },
    "model_version": {
      "id": "@modelVersionID",
      "created_at": "2018-03-14T15:33:58.685871306Z",
      "status": {
        "code": 21102,
        "description": "Model not yet trained"
      }
    }
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->createModel('@modelID')->executeSync();
        $this->assertTrue($response->isSuccessful());

        $model = $response->get();
        $this->assertEquals('@modelID', $model->modelID());
        $this->assertEquals('@modelName', $model->name());
        $this->assertEquals('@appID', $model->appID());
        $this->assertEquals('@appID', $model->appID());
        $this->assertEquals('@modelVersionID', $model->modelVersion()->id());

        $expectedRequestBody = <<< EOD
{
  "model": {
    "id": "@modelID"
  }
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());
    }

    public function testModifyModel()
    {
        $patchedResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "models": [
    {
      "id": "@modelID",
      "name": "@newModelName",
      "created_at": "2017-11-27T08:35:13.911899Z",
      "app_id": "@appID",
      "output_info": {
        "output_config": {
          "concepts_mutually_exclusive": true,
          "closed_environment": true
        },
        "message": "Show output_info with: GET /models/{model_id}/output_info",
        "type": "concept",
        "type_ext": "concept"
      },
      "model_version": {
        "id": "@modelVersionID",
        "created_at": "2017-11-27T08:35:14.298376733Z",
        "status": {
          "code": 21102,
          "description": "Model not yet trained"
        }
      }
    }
  ]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, null, $patchedResponse, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->modifyModel('@modelID')
            ->withModifyAction(ModifyAction::merge())
            ->withName('@newModelName')
            ->withConcepts([new Concept('@conceptID1')])
            ->withAreConceptsMutuallyExclusive(true)
            ->withIsEnvironmentClosed(true)
            ->executeSync();

        $this->assertTrue($response->isSuccessful());

        $model = $response->get();
        $this->assertEquals('@modelID', $model->modelID());
        $this->assertEquals('@newModelName', $model->name());
        $this->assertEquals('@modelVersionID', $model->modelVersion()->id());
        $this->assertEquals(true, $model->outputInfo()->areConceptsMutuallyExclusive());
        $this->assertEquals(true, $model->outputInfo()->isEnvironmentClosed());

        $expectedRequestBody = <<< EOD
{
  "models": [
    {
      "id": "@modelID",
      "name": "@newModelName",
      "output_info": {
        "data": {
          "concepts": [
            {
              "id": "@conceptID1"
            }
          ]
        },
        "output_config": {
          "concepts_mutually_exclusive": true,
          "closed_environment": true
        }
      }
    }
  ],
  "action": "merge"
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->patchedBody());
    }

    public function testDeleteAllModels()
    {
        $deleteResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  }
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, null, null, $deleteResponse);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->deleteAllModels()->executeSync();

        $this->assertTrue($response->isSuccessful());

        $expectedRequestBody = <<< EOD
{
  "delete_all": true
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->deletedBody());
    }
}
