<?php

namespace Unit;

use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Inputs\ClarifaiFileImage;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Inputs\ModifyAction;
use Clarifai\DTOs\Models\ConceptModel;
use Clarifai\DTOs\Models\Model;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\DTOs\Workflows\WorkflowBatchPredictResult;
use Clarifai\DTOs\Workflows\WorkflowPredictResult;
use PHPUnit\Framework\TestCase;

class WorkflowUnitTest extends TestCase
{
    const TINY_PNG_IMAGE_BASE64 =
        "iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z/C/HgAGgwJ/lK3Q6wAAAABJRU5ErkJggg==";

    public function testWorkflowPredictWithUrl()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "workflow": {
    "id": "@workflowID",
    "app_id": "@appID",
    "created_at": "2017-07-10T01:45:05.672880Z"
  },
  "results": [
    {
      "status": {
        "code": 10000,
        "description": "Ok"
      },
      "input": {
        "id": "@inputID",
        "data": {
          "image": {
            "url": "@inputURL"
          }
        }
      },
      "outputs": [
        {
          "id": "@outputID1",
          "status": {
            "code": 10000,
            "description": "Ok"
          },
          "created_at": "2017-07-10T12:01:44.929928529Z",
          "model": {
            "id": "d16f390eb32cad478c7ae150069bd2c6",
            "name": "moderation",
            "created_at": "2017-05-12T21:28:00.471607Z",
            "app_id": "main",
            "output_info": {
              "message": "Show output_info with: GET /models/{model_id}/output_info",
              "type": "concept",
              "type_ext": "concept"
            },
            "model_version": {
              "id": "b42ac907ac93483484483a0040a386be",
              "created_at": "2017-05-12T21:28:00.471607Z",
              "status": {
                "code": 21100,
                "description": "Model trained successfully"
              }
            }
          },
          "data": {
            "concepts": [
              {
                "id": "@conceptID11",
                "name": "safe",
                "value": 0.99999714,
                "app_id": "main"
              }
            ]
          }
        },
        {
          "id": "@outputID2",
          "status": {
            "code": 10000,
            "description": "Ok"
          },
          "created_at": "2017-07-10T12:01:44.929941126Z",
          "model": {
            "id": "aaa03c23b3724a16a56b629203edc62c",
            "name": "general-v1.3",
            "created_at": "2016-02-26T23:38:40.086101Z",
            "app_id": "main",
            "output_info": {
              "message": "Show output_info with: GET /models/{model_id}/output_info",
              "type": "concept",
              "type_ext": "concept"
            },
            "model_version": {
              "id": "aa9ca48295b37401f8af92ad1af0d91d",
              "created_at": "2016-07-13T00:58:55.915745Z",
              "status": {
                "code": 21100,
                "description": "Model trained successfully"
              }
            }
          },
          "data": {
            "concepts": [
              {
                "id": "@conceptID21",
                "name": "train",
                "value": 0.9989112,
                "app_id": "main"
              },
              {
                "id": "@conceptID22",
                "name": "railway",
                "value": 0.9975532,
                "app_id": "main"
              }
            ]
          }
        }
      ]
    }
  ]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->workflowPredict('@workflowID', new ClarifaiURLImage('@url'))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        /** @var WorkflowPredictResult $result */
        $result = $response->get();
        $this->assertEquals('@workflowID', $result->workflow()->id());
        $this->assertEquals('@appID', $result->workflow()->appID());

        $workflowResults = $result->workflowResult();
        $this->assertEquals('@inputID', $workflowResults->input()->id());

        $output1 = $workflowResults->predictions()[0];
        $this->assertEquals('@outputID1', $output1->id());
        $this->assertEquals('@conceptID11', $output1->data()[0]->id());

        $output2 = $workflowResults->predictions()[1];
        $this->assertEquals('@outputID2', $output2->id());
        $this->assertEquals('@conceptID21', $output2->data()[0]->id());
        $this->assertEquals('@conceptID22', $output2->data()[1]->id());


        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "data": {
        "image": {
          "url": "@url"
        }
      }
    }
  ]
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());
    }

    public function testWorkflowPredictWithBase64()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "workflow": {
    "id": "@workflowID",
    "app_id": "@appID",
    "created_at": "2017-06-15T15:17:30.462323Z"
  },
  "results": [
    {
      "status": {
        "code": 10000,
        "description": "Ok"
      },
      "input": {
        "id": "@inputID",
        "data": {
          "image": {
            "base64": "iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z/C/HgAGgwJ/lK3Q6wAAAABJRU5ErkJggg=="
          }
        }
      },
      "outputs": [
        {
          "id": "@outputID1",
          "status": {
            "code": 10000,
            "description": "Ok"
          },
          "created_at": "2019-01-20T18:22:36.057985725Z",
          "model": {
            "id": "bd367be194cf45149e75f01d59f77ba7",
            "name": "food-items-v1.0",
            "created_at": "2016-09-17T22:18:59.955626Z",
            "app_id": "main",
            "output_info": {
              "message": "Show output_info with: GET /models/{model_id}/output_info",
              "type": "concept",
              "type_ext": "concept"
            },
            "model_version": {
              "id": "dfebc169854e429086aceb8368662641",
              "created_at": "2016-09-17T22:18:59.955626Z",
              "status": {
                "code": 21100,
                "description": "Model trained successfully"
              },
              "train_stats": {}
            },
            "display_name": "Food"
          },
          "data": {
            "concepts": [
              {
                "id": "@conceptID11",
                "name": "raspberry",
                "value": 0.8684727,
                "app_id": "main"
              },
              {
                "id": "@conceptID12",
                "name": "strawberry",
                "value": 0.7979152,
                "app_id": "main"
              }
            ]
          }
        },
        {
          "id": "@outputID2",
          "status": {
            "code": 10000,
            "description": "Ok"
          },
          "created_at": "2019-01-20T18:22:36.058002759Z",
          "model": {
            "id": "aaa03c23b3724a16a56b629203edc62c",
            "name": "general",
            "created_at": "2016-03-09T17:11:39.608845Z",
            "app_id": "main",
            "output_info": {
              "message": "Show output_info with: GET /models/{model_id}/output_info",
              "type": "concept",
              "type_ext": "concept"
            },
            "model_version": {
              "id": "aa9ca48295b37401f8af92ad1af0d91d",
              "created_at": "2016-07-13T01:19:12.147644Z",
              "status": {
                "code": 21100,
                "description": "Model trained successfully"
              },
              "train_stats": {}
            },
            "display_name": "General"
          },
          "data": {
            "concepts": [
              {
                "id": "@conceptID21",
                "name": "design",
                "value": 0.9859183,
                "app_id": "main"
              },
              {
                "id": "@conceptID22",
                "name": "art",
                "value": 0.98318106,
                "app_id": "main"
              }
            ]
          }
        }
      ]
    }
  ]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->workflowPredict('@workflowID',
                new ClarifaiFileImage(base64_decode(self::TINY_PNG_IMAGE_BASE64)))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        /** @var WorkflowPredictResult $result */
        $result = $response->get();
        $this->assertEquals('@workflowID', $result->workflow()->id());
        $this->assertEquals('@appID', $result->workflow()->appID());

        $workflowResults = $result->workflowResult();
        $this->assertEquals('@inputID', $workflowResults->input()->id());

        $output1 = $workflowResults->predictions()[0];
        $this->assertEquals('@outputID1', $output1->id());
        $this->assertEquals('@conceptID11', $output1->data()[0]->id());

        $output2 = $workflowResults->predictions()[1];
        $this->assertEquals('@outputID2', $output2->id());
        $this->assertEquals('@conceptID21', $output2->data()[0]->id());
        $this->assertEquals('@conceptID22', $output2->data()[1]->id());


        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "data": {
        "image": {
          "base64": "iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z/C/HgAGgwJ/lK3Q6wAAAABJRU5ErkJggg=="
        }
      }
    }
  ]
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());
    }

    public function testWorkflowBatch()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "workflow": {
    "id": "@workflowID",
    "app_id": "@appID",
    "created_at": "2017-06-15T15:17:30.462323Z"
  },
  "results": [
    {
      "status": {
        "code": 10000,
        "description": "Ok"
      },
      "input": {
        "id": "@inputID1",
        "data": {
          "image": {
            "url": "@url1"
          }
        }
      },
      "outputs": [
        {
          "id": "@outputID11",
          "status": {
            "code": 10000,
            "description": "Ok"
          },
          "created_at": "2019-01-29T17:36:23.736685542Z",
          "model": {
            "id": "@modelID1",
            "name": "food-items-v1.0",
            "created_at": "2016-09-17T22:18:59.955626Z",
            "app_id": "main",
            "output_info": {
              "message": "Show output_info with: GET /models/{model_id}/output_info",
              "type": "concept",
              "type_ext": "concept"
            },
            "model_version": {
              "id": "@modelVersionID1",
              "created_at": "2016-09-17T22:18:59.955626Z",
              "status": {
                "code": 21100,
                "description": "Model trained successfully"
              },
              "train_stats": {}
            },
            "display_name": "Food"
          },
          "data": {}
        },
        {
          "id": "@outputID12",
          "status": {
            "code": 10000,
            "description": "Ok"
          },
          "created_at": "2019-01-29T17:36:23.736712374Z",
          "model": {
            "id": "@modelID2",
            "name": "general",
            "created_at": "2016-03-09T17:11:39.608845Z",
            "app_id": "main",
            "output_info": {
              "message": "Show output_info with: GET /models/{model_id}/output_info",
              "type": "concept",
              "type_ext": "concept"
            },
            "model_version": {
              "id": "@modelVersion2",
              "created_at": "2016-07-13T01:19:12.147644Z",
              "status": {
                "code": 21100,
                "description": "Model trained successfully"
              },
              "train_stats": {}
            },
            "display_name": "General"
          },
          "data": {
            "concepts": [
              {
                "id": "@conceptID11",
                "name": "people",
                "value": 0.9963381,
                "app_id": "main"
              },
              {
                "id": "@conceptID12",
                "name": "one",
                "value": 0.9879056,
                "app_id": "main"
              },
              {
                "id": "@conceptID13",
                "name": "portrait",
                "value": 0.9849082,
                "app_id": "main"
              }
            ]
          }
        }
      ]
    },
    {
      "status": {
        "code": 10000,
        "description": "Ok"
      },
      "input": {
        "id": "@inputID2",
        "data": {
          "image": {
            "url": "@url2"
          }
        }
      },
      "outputs": [
        {
          "id": "@outputID21",
          "status": {
            "code": 10000,
            "description": "Ok"
          },
          "created_at": "2019-01-29T17:36:23.736685542Z",
          "model": {
            "id": "@modelID1",
            "name": "food-items-v1.0",
            "created_at": "2016-09-17T22:18:59.955626Z",
            "app_id": "main",
            "output_info": {
              "message": "Show output_info with: GET /models/{model_id}/output_info",
              "type": "concept",
              "type_ext": "concept"
            },
            "model_version": {
              "id": "@modelVersion1",
              "created_at": "2016-09-17T22:18:59.955626Z",
              "status": {
                "code": 21100,
                "description": "Model trained successfully"
              },
              "train_stats": {}
            },
            "display_name": "Food"
          },
          "data": {
            "concepts": [
              {
                "id": "@concept21",
                "name": "spatula",
                "value": 0.9805687,
                "app_id": "main"
              }
            ]
          }
        },
        {
          "id": "@outputID22",
          "status": {
            "code": 10000,
            "description": "Ok"
          },
          "created_at": "2019-01-29T17:36:23.736712374Z",
          "model": {
            "id": "@modelID2",
            "name": "general",
            "created_at": "2016-03-09T17:11:39.608845Z",
            "app_id": "main",
            "output_info": {
              "message": "Show output_info with: GET /models/{model_id}/output_info",
              "type": "concept",
              "type_ext": "concept"
            },
            "model_version": {
              "id": "@modelVersion2",
              "created_at": "2016-07-13T01:19:12.147644Z",
              "status": {
                "code": 21100,
                "description": "Model trained successfully"
              },
              "train_stats": {}
            },
            "display_name": "General"
          },
          "data": {
            "concepts": [
              {
                "id": "@conceptID31",
                "name": "eyewear",
                "value": 0.99984586,
                "app_id": "main"
              },
              {
                "id": "@conceptID32",
                "name": "lens",
                "value": 0.999823,
                "app_id": "main"
              },
              {
                "id": "@conceptID33",
                "name": "eyeglasses",
                "value": 0.99980056,
                "app_id": "main"
              }
            ]
          }
        }
      ]
    }
  ]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->workflowBatchPredict('@workflowID',
            [new ClarifaiURLImage('@url1'), new ClarifaiURLImage('@url2')])
            ->withMinValue(0.98)
            ->withMaxConcepts(3)
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "data": {
        "image": {
          "url": "@url1"
        }
      }
    },
    {
      "data": {
        "image": {
          "url": "@url2"
        }
      }
    }
  ],
  "output_config": {
    "max_concepts": 3,
    "min_value": 0.98
  }
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());

        /** @var WorkflowBatchPredictResult $result */
        $result = $response->get();
        $this->assertEquals('@workflowID', $result->workflow()->id());
        $this->assertEquals('@appID', $result->workflow()->appID());

        $workflowResults1 = $result->workflowResults()[0];
        $this->assertEquals('@inputID1', $workflowResults1->input()->id());

        $output1 = $workflowResults1->predictions()[0];
        $this->assertEquals('@outputID11', $output1->id());

        $output2 = $workflowResults1->predictions()[1];
        $this->assertEquals('@outputID12', $output2->id());
        $this->assertEquals('@conceptID11', $output2->data()[0]->id());
        $this->assertEquals('@conceptID12', $output2->data()[1]->id());

        $workflowResults1 = $result->workflowResults()[0];
        $this->assertEquals('@inputID1', $workflowResults1->input()->id());

        $output1 = $workflowResults1->predictions()[0];
        $this->assertEquals('@outputID11', $output1->id());

        $output2 = $workflowResults1->predictions()[1];
        $this->assertEquals('@outputID12', $output2->id());
        $this->assertEquals('@conceptID11', $output2->data()[0]->id());
        $this->assertEquals('@conceptID12', $output2->data()[1]->id());
    }
}
