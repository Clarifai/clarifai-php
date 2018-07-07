<?php

namespace Unit;

use Clarifai\DTOs\Crop;
use Clarifai\DTOs\Outputs\ClarifaiOutput;
use Clarifai\DTOs\Predictions\Concept;
use PHPUnit\Framework\TestCase;

use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Models\ModelType;

class PredictUnitTest extends TestCase
{
    public function testPredict()
    {
        $postResponse = <<<EOD
{
    "status": {
        "code": 10000,
        "description": "Ok"
    },
    "outputs": [{
        "id": "@outputID",
        "status": {
            "code": 10000,
            "description": "Ok"
        },
        "created_at": "2017-11-17T19:32:58.760477937Z",
        "model": {
            "id": "@modelID",
            "name": "@modelName",
            "created_at": "2016-03-09T17:11:39.608845Z",
            "app_id": "main",
            "output_info": {
                "message": "Show output_info with: GET /models/{model_id}/output_info",
                "type": "concept",
                "type_ext": "concept"
            },
            "model_version": {
                "id": "@modelVersionID",
                "created_at": "2016-07-13T01:19:12.147644Z",
                "status": {
                    "code": 21100,
                    "description": "Model trained successfully"
                }
            },
            "display_name": "@modelDisplayName"
        },
        "input": {
            "id": "@inputID",
            "data": {
                "image": {
                    "url": "@imageUrl"
                }
            }
        },
        "data": {
            "concepts": [{
                "id": "@conceptID1",
                "name": "@conceptName1",
                "value": 0.99,
                "app_id": "main"
            }, {
                "id": "@conceptID2",
                "name": "@conceptName2",
                "value": 0.98,
                "app_id": "main"
            }]
        }
    }]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->predict(ModelType::concept(), "", new ClarifaiURLImage("@url"))
            ->executeSync();
        $output = $response->get();

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

    public function testPredictWithCrop()
    {
        $postResponse = <<<EOD
{
    "status": {
        "code": 10000,
        "description": "Ok"
    },
    "outputs": [{
        "id": "@outputID",
        "status": {
            "code": 10000,
            "description": "Ok"
        },
        "created_at": "2017-11-17T19:32:58.760477937Z",
        "model": {
            "id": "@modelID",
            "name": "@modelName",
            "created_at": "2016-03-09T17:11:39.608845Z",
            "app_id": "main",
            "output_info": {
                "message": "Show output_info with: GET /models/{model_id}/output_info",
                "type": "concept",
                "type_ext": "concept"
            },
            "model_version": {
                "id": "@modelVersionID",
                "created_at": "2016-07-13T01:19:12.147644Z",
                "status": {
                    "code": 21100,
                    "description": "Model trained successfully"
                }
            },
            "display_name": "@modelDisplayName"
        },
        "input": {
            "id": "@inputID",
            "data": {
                "image": {
                    "url": "@imageUrl"
                }
            }
        },
        "data": {
            "concepts": [{
                "id": "@conceptID1",
                "name": "@conceptName1",
                "value": 0.99,
                "app_id": "main"
            }, {
                "id": "@conceptID2",
                "name": "@conceptName2",
                "value": 0.98,
                "app_id": "main"
            }]
        }
    }]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $client->predict(ModelType::concept(), "", (new ClarifaiURLImage("@url"))
            ->withCrop(new Crop(0.1, 0.2, 0.3, 0.4)))
            ->executeSync();

        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "data": {
        "image": {
          "url": "@url",
          "crop": [0.1, 0.2, 0.3, 0.4]
        }
      }
    }
  ]
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());
    }

    public function testBatchPredict()
    {
        $postResponse = <<<EOD
{
    "status": {
        "code": 10000,
        "description": "Ok"
    },
    "outputs": [{
        "id": "@outputID1",
        "status": {
            "code": 10000,
            "description": "Ok"
        },
        "created_at": "2017-11-17T19:32:58.760477937Z",
        "model": {
            "id": "@modelID1",
            "name": "@modelName1",
            "created_at": "2016-03-09T17:11:39.608845Z",
            "app_id": "main",
            "output_info": {
                "message": "Show output_info with: GET /models/{model_id}/output_info",
                "type": "concept",
                "type_ext": "concept"
            },
            "model_version": {
                "id": "@modelVersionID1",
                "created_at": "2016-07-13T01:19:12.147644Z",
                "status": {
                    "code": 21100,
                    "description": "Model trained successfully"
                }
            },
            "display_name": "@modelDisplayName1"
        },
        "input": {
            "id": "@inputID1",
            "data": {
                "image": {
                    "url": "@imageUrl1"
                }
            }
        },
        "data": {
            "concepts": [{
                "id": "@conceptID11",
                "name": "@conceptName11",
                "value": 0.99,
                "app_id": "main"
            }, {
                "id": "@conceptID12",
                "name": "@conceptName12",
                "value": 0.98,
                "app_id": "main"
            }]
        }
    },
    {
        "id": "@outputID2",
        "status": {
            "code": 10000,
            "description": "Ok"
        },
        "created_at": "2017-11-17T19:32:58.760477937Z",
        "model": {
            "id": "@modelID2",
            "name": "@modelName2",
            "created_at": "2016-03-09T17:11:39.608845Z",
            "app_id": "main",
            "output_info": {
                "message": "Show output_info with: GET /models/{model_id}/output_info",
                "type": "concept",
                "type_ext": "concept"
            },
            "model_version": {
                "id": "@modelVersionID2",
                "created_at": "2016-07-13T01:19:12.147644Z",
                "status": {
                    "code": 21100,
                    "description": "Model trained successfully"
                }
            },
            "display_name": "@modelDisplayName2"
        },
        "input": {
            "id": "@inputID2",
            "data": {
                "image": {
                    "url": "@imageUrl2"
                }
            }
        },
        "data": {
            "concepts": [{
                "id": "@conceptID21",
                "name": "@conceptName21",
                "value": 0.99,
                "app_id": "main"
            }, {
                "id": "@conceptID22",
                "name": "@conceptName22",
                "value": 0.98,
                "app_id": "main"
            }]
        }
    }
]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->batchPredict(ModelType::concept(), "",
            [new ClarifaiURLImage("@url1"), new ClarifaiURLImage("@url2")])
            ->executeSync();

        $this->assertTrue($response->isSuccessful());

        /** @var ClarifaiOutput[] $outputs */
        $outputs = $response->get();

        /** @var Concept[] $concepts1 */
        $concepts1 = $outputs[0]->data();

        $this->assertEquals(2, count($concepts1));
        $this->assertEquals('@conceptID11', $concepts1[0]->id());
        $this->assertEquals('@conceptName11', $concepts1[0]->name());
        $this->assertEquals('@conceptID12', $concepts1[1]->id());
        $this->assertEquals('@conceptName12', $concepts1[1]->name());

        /** @var Concept[] $concepts2 */
        $concepts2 = $outputs[1]->data();

        $this->assertEquals(2, count($concepts2));
        $this->assertEquals('@conceptID21', $concepts2[0]->id());
        $this->assertEquals('@conceptName21', $concepts2[0]->name());
        $this->assertEquals('@conceptID22', $concepts2[1]->id());
        $this->assertEquals('@conceptName22', $concepts2[1]->name());

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
  ]
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());
    }
}
