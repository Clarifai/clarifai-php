<?php

namespace Unit;

use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Inputs\ModifyAction;
use Clarifai\DTOs\Models\ConceptModel;
use Clarifai\DTOs\Models\Model;
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

        /** @var ConceptModel $model */
        $model = $response->get();
        $this->assertEquals('@modelID', $model->modelID());
        $this->assertEquals('@modelName', $model->name());
        $this->assertEquals('@appID', $model->appID());
        $this->assertEquals('@appID', $model->appID());
        $this->assertEquals('@modelVersionID', $model->modelVersion()->id());
    }

    public function testGetModels()
    {
        $getResponse = <<<EOD
{
  "status": {
    "code": 10000,
      "description": "Ok"
    },
  "models": [
    {
      "id": "@modelID1",
      "name": "@modelName1",
      "created_at": "2019-01-16T23:33:46.605294Z",
      "app_id": "main",
      "output_info": {
        "message": "Show output_info with: GET /models/{model_id}/output_info",
        "type": "facedetect",
        "type_ext": "facedetect"
      },
      "model_version": {
        "id": "28b2ff6148684aa2b18a34cd004b4fac",
        "created_at": "2019-01-16T23:33:46.605294Z",
        "status": {
          "code": 21100,
          "description": "Model trained successfully"
        },
        "train_stats": {}
      },
      "display_name": "Face Detection"
    },
    {
      "id": "@modelID2",
      "name": "@modelName2",
      "created_at": "2019-01-16T23:33:46.605294Z",
      "app_id": "main",
      "output_info": {
        "message": "Show output_info with: GET /models/{model_id}/output_info",
        "type": "embed",
        "type_ext": "detect-embed"
      },
      "model_version": {
        "id": "fc6999e5eb274dfdba826f6b1c7ffdab",
        "created_at": "2019-01-16T23:33:46.605294Z",
        "status": {
          "code": 21100,
          "description": "Model trained successfully"
        },
        "train_stats": {}
      },
      "display_name": "Face Embedding"
    }
  ]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getModels()->executeSync();
        $this->assertTrue($response->isSuccessful());

        /** @var Model[] $models */
        $models = $response->get();

        $this->assertEquals('@modelID1', $models[0]->modelID());
        $this->assertEquals('@modelName1', $models[0]->name());
        $this->assertEquals('facedetect', $models[0]->type());

        $this->assertEquals('@modelID2', $models[1]->modelID());
        $this->assertEquals('@modelName2', $models[1]->name());
        $this->assertEquals('detect-embed', $models[1]->type());
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

        /** @var ConceptModel $model */
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

    public function testCreateModelGeneric()
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
    "created_at": "2019-01-18T13:51:40.798977081Z",
    "app_id": "@appID",
    "output_info": {
      "output_config": {
        "concepts_mutually_exclusive": false,
        "closed_environment": false,
        "max_concepts": 0,
        "min_value": 0
      },
      "message": "Show output_info with: GET /models/{model_id}/output_info",
      "type": "concept",
      "type_ext": "concept"
    },
    "model_version": {
      "id": "@modelVersionID",
      "created_at": "2019-01-18T13:51:40.818805581Z",
      "status": {
        "code": 21102,
        "description": "Model not yet trained"
      },
      "train_stats": {}
    }
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->createModelGeneric('@modelID')
            ->withName("@modelName")
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        /** @var ConceptModel $model */
        $model = $response->get();
        $this->assertEquals('@modelID', $model->modelID());
        $this->assertEquals('@modelName', $model->name());
        $this->assertEquals('@appID', $model->appID());
        $this->assertEquals('@appID', $model->appID());
        $this->assertEquals('@modelVersionID', $model->modelVersion()->id());

        $expectedRequestBody = <<< EOD
{
  "model": {
    "id": "@modelID",
    "name": "@modelName"
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

        /** @var ConceptModel $model */
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

    public function testTrainModel()
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
    "created_at": "2019-01-20T15:51:21.641006Z",
    "app_id": "@appID",
    "output_info": {
      "output_config": {
        "concepts_mutually_exclusive": false,
        "closed_environment": false,
        "max_concepts": 0,
        "min_value": 0
      },
      "message": "Show output_info with: GET /models/{model_id}/output_info",
      "type": "concept",
      "type_ext": "concept"
    },
    "model_version": {
      "id": "@modelVersionID",
      "created_at": "2019-01-20T15:51:25.093744401Z",
      "status": {
        "code": 21103,
        "description": "Custom model is currently in queue for training, waiting on inputs to process."
      },
      "active_concept_count": 2,
      "train_stats": {}
    }
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->trainModel(ModelType::concept(), '@modelID')->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('/v2/models/@modelID/versions', $httpClient->requestedUrl());

        $expectedRequestBody = <<< EOD
{}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());

        /** @var ConceptModel $model */
        $model = $response->get();
        $this->assertEquals('@modelID', $model->modelID());
        $this->assertEquals('@modelName', $model->name());
        $this->assertEquals('@appID', $model->appID());
        $this->assertEquals('@modelVersionID', $model->modelVersion()->id());
    }

    public function testDeleteModel()
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
        $response = $client->deleteModel('@modelID')->executeSync();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('/v2/models/@modelID', $httpClient->requestedUrl());
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

    public function testGetModelInputs()
    {
        $getResponse = <<<EOD
{
    "status": {
        "code": 10000,
        "description": "Ok"
    },
    "inputs": [{
        "id": "@inputID",
        "data": {
            "image": {
                "url": "@imageURL"
            },
            "concepts": [{
                "id": "@conceptID",
                "name": "@conceptName",
                "value": 1,
                "app_id": "@conceptAppID"
            }]
        },
        "created_at": "2017-10-15T16:30:52.964888Z",
        "status": {
            "code": 30000,
            "description": "Download complete"
        }
    }]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getModelInputs("@modelID")
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("/v2/models/@modelID/inputs", $httpClient->requestedUrl());

        /** @var ClarifaiURLImage $image */
        $image = $response->get()[0];

        $this->assertEquals('@inputID', $image->id());
        $this->assertEquals('@imageURL', $image->url());
        $this->assertEquals('@conceptID', $image->positiveConcepts()[0]->id());
    }
}
