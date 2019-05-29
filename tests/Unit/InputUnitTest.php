<?php

namespace Unit;

use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Crop;
use Clarifai\DTOs\Feedbacks\ConceptFeedback;
use Clarifai\DTOs\Feedbacks\FaceFeedback;
use Clarifai\DTOs\Feedbacks\Feedback;
use Clarifai\DTOs\Feedbacks\RegionFeedback;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Inputs\ClarifaiInputsStatus;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Inputs\ModifyAction;
use Clarifai\DTOs\Predictions\Concept;
use PHPUnit\Framework\TestCase;

class InputUnitTest extends TestCase
{

    public function testGetInput()
    {
        $getResponse = <<<EOD
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
      },
      "geo": {
        "geo_point": {
          "longitude": 55,
          "latitude": 66
        }
      }
    },
    "created_at": "2019-01-17T14:02:21.216473Z",
    "modified_at": "2019-01-17T14:02:21.800792Z",
    "status": {
      "code": 30000,
      "description": "Download complete"
    }
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getInput('@inputID')
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("/v2/inputs/@inputID", $httpClient->requestedUrl());

        /** @var ClarifaiURLImage $input */
        $input = $response->get();
        $this->assertEquals('@inputID', $input->id());
        $this->assertEquals('@inputURL', $input->url());
    }

    public function testGetInputs()
    {
        $getResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "inputs": [
    {
      "id": "@inputID1",
      "data": {
        "image": {
          "url": "@inputURL1"
        },
        "geo": {
          "geo_point": {
            "longitude": 55,
            "latitude": 66
          }
        }
      },
      "created_at": "2019-01-17T14:02:21.216473Z",
      "modified_at": "2019-01-17T14:02:21.800792Z",
      "status": {
        "code": 30000,
        "description": "Download complete"
      }
    },
    {
      "id": "@inputID2",
      "data": {
        "image": {
          "url": "@inputURL2"
        }
      },
      "created_at": "2019-01-17T14:02:21.216473Z",
      "modified_at": "2019-01-17T14:02:21.800792Z",
      "status": {
        "code": 30000,
        "description": "Download complete"
      }
    }
  ]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getInputs()
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("/v2/inputs", $httpClient->requestedUrl());

        /** @var ClarifaiURLImage[] $inputs */
        $inputs = $response->get();

        $this->assertEquals('@inputID1', $inputs[0]->id());
        $this->assertEquals('@inputURL1', $inputs[0]->url());

        $this->assertEquals('@inputID2', $inputs[1]->id());
        $this->assertEquals('@inputURL2', $inputs[1]->url());
    }

    public function testGetInputsStatus()
    {
        $getResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "counts": {
    "processed": 1,
    "to_process": 2,
    "errors": 3,
    "processing": 4,
    "reindexed": 5,
    "to_reindex": 6,
    "reindex_errors": 7,
    "reindexing": 8
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getInputsStatus()
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("/v2/inputs/status", $httpClient->requestedUrl());

        /** @var ClarifaiInputsStatus $inputsStatus */
        $inputsStatus = $response->get();

        $this->assertEquals(1, $inputsStatus->processed());
        $this->assertEquals(2, $inputsStatus->toProcess());
        $this->assertEquals(3, $inputsStatus->errors());
        $this->assertEquals(4, $inputsStatus->processing());
        // TODO(Rok) MEDIUM: Expose the other fields.
    }

    public function testAddInputs()
    {
        $postResponse = <<<EOD
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
            "concepts": [
                {
                  "id": "@positiveConcept1",
                  "name": "@positiveConceptName1",
                  "value": 1
                },
                {
                  "id": "@positiveConcept2",
                  "value": 1
                },
                {
                  "id": "@negativeConcept1",
                  "name": "@negativeConceptName1",
                  "value": 0
                },
                {
                  "id": "@negativeConcept2",
                  "value": 0
                }
            ]
        },
        "created_at": "2017-10-13T20:53:00.253139Z",
        "modified_at": "2017-10-13T20:53:00.868659782Z",
        "status": {
            "code": 30200,
            "description": ""
        }
    }]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client
            ->addInputs([
                (new ClarifaiURLImage('@url1'))
                    ->withID('@id1')
                    ->withPositiveConcepts([new Concept('positiveConcept')]),
                (new ClarifaiURLImage('@url2'))
                    ->withID("@id2")
                    ->withNegativeConcepts([new Concept('negativeConcept')])])
            ->executeSync();

        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "id": "@id1",
      "data": {
        "image": {
          "url": "@url1"
        },
        "concepts": [
          {
            "id": "positiveConcept",
            "value": 1
          }
        ]
      }
    },
    {
      "id": "@id2",
      "data": {
        "image": {
          "url": "@url2"
        },
        "concepts": [
          {
            "id": "negativeConcept",
            "value": 0
          }
        ]
      }
    }
  ]
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());


        $inputs = $response->get();
        $this->assertEquals('@imageURL', $inputs[0]->url());
    }

    public function testAddInputWithMetadata()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "inputs": [
    {
      "id": "@inputID",
      "data": {
        "image": {
          "url": "@imageURL"
        },
        "metadata": {
          "key1": "value1"
        }
      },
      "created_at": "2019-02-25T12:13:47.706491702Z",
      "modified_at": "2019-02-25T12:13:48.190683251Z",
      "status": {
        "code": 30000,
        "description": "Download complete"
      }
    }
  ]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client
            ->addInputs([
                (new ClarifaiURLImage('@imageURL'))
                    ->withID("@inputID")
                    ->withAllowDuplicateUrl(true)
                    ->withMetadata(['key1' => 'value1'])
                ]
            )
            ->executeSync();

        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "id": "@inputID",
      "data": {
        "image": {
          "url": "@imageURL",
          "allow_duplicate_url": true
        },
        "metadata": {
          "key1": "value1"
        }
      }
    }
  ]
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());

        $inputs = $response->get();
        $this->assertEquals('@imageURL', $inputs[0]->url());
    }

    public function testModifyInputConcepts()
    {
        $patchResponse = <<<EOD
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
            "concepts": [
                {
                  "id": "@positiveConcept1",
                  "name": "@positiveConceptName1",
                  "value": 1
                },
                {
                  "id": "@positiveConcept2",
                  "value": 1
                },
                {
                  "id": "@negativeConcept1",
                  "name": "@negativeConceptName1",
                  "value": 0
                },
                {
                  "id": "@negativeConcept2",
                  "value": 0
                }
            ]
        },
        "created_at": "2017-10-13T20:53:00.253139Z",
        "modified_at": "2017-10-13T20:53:00.868659782Z",
        "status": {
            "code": 30200,
            "description": "Input image modification success"
        }
    }]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, null, $patchResponse, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client
            ->modifyInput("@inputID", ModifyAction::merge())
            ->withPositiveConcepts([
                (new Concept('@positiveConcept1'))->withName('@positiveConceptName1'),
                new Concept('@positiveConcept2')
            ])
            ->withNegativeConcepts([
                (new Concept('@negativeConcept1'))->withName('@negativeConceptName1'),
                new Concept('@negativeConcept2')
            ])
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
        /** @var ClarifaiInput $input */
        $input = $response->get();
        $this->assertEquals('@positiveConcept1', $input->positiveConcepts()[0]->id());

        $expectedRequestBody = <<< EOD
{
    "inputs": [
      {
        "id": "@inputID",
        "data": {
          "concepts": [
            {
              "id": "@positiveConcept1",
              "name": "@positiveConceptName1",
              "value": 1.0
            },
            {
              "id": "@positiveConcept2",
              "value": 1.0
            },
            {
              "id": "@negativeConcept1",
              "name": "@negativeConceptName1",
              "value": 0.0
            },
            {
              "id": "@negativeConcept2",
              "value": 0.0
            }
          ]
        }
      }
    ],
    "action":"merge"
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->patchedBody());
    }

    public function testModifyInputRegions()
    {
        $patchResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "inputs": [
    {
      "id": "@inputID",
      "data": {
        "image": {
          "url": "@imageURL"
        },
        "concepts": [
          {
            "id": "@concept1",
            "name": "@concept1",
            "value": 1,
            "app_id": "@appID"
          },
          {
            "id": "@concept2",
            "name": "@concept2",
            "value": 0,
            "app_id": "@appID"
          }
        ]
      },
      "created_at": "2019-01-29T15:23:21.188492Z",
      "modified_at": "2019-01-29T15:23:21.575667Z",
      "status": {
        "code": 30200,
        "description": "Input image modification success"
      }
    }
  ]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, null, $patchResponse, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client
            ->modifyInput("@inputID", ModifyAction::overwrite())
            ->withRegionFeedbacks([
                (new RegionFeedback())
                    ->withCrop(new Crop(0.1, 0.2, 0.3, 0.4))
                    ->withFeedback(Feedback::misplaced())
                    ->withConceptFeedbacks([
                        new ConceptFeedback('@concept1', true),
                        new ConceptFeedback('@concept2', false),
                    ])
                    ->withRegionID('@regionID')
                    ->withFaceFeedback(new FaceFeedback([
                        new ConceptFeedback('@faceConcept1', true),
                        new ConceptFeedback('@faceConcept2', false),
                    ]))
            ])
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
        /** @var ClarifaiInput $input */
        $input = $response->get();
        $this->assertEquals('@concept1', $input->positiveConcepts()[0]->id());

        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "id": "@inputID",
      "data": {
        "regions": [
          {
            "id": "@regionID",
            "region_info": {
              "bounding_box": {
                "top_row": 0.1,
                "left_col": 0.2,
                "bottom_row": 0.3,
                "right_col": 0.4
              },
              "feedback": "misplaced"
            },
            "data": {
              "concepts": [
                {
                  "id": "@concept1",
                  "value": 1
                },
                {
                  "id": "@concept2",
                  "value": 0
                }
              ],
              "face": {
                "identity": {
                  "concepts": [
                    {
                      "id": "@faceConcept1",
                      "value": 1
                    },
                    {
                      "id": "@faceConcept2",
                      "value": 0
                    }
                  ]
                }
              }
            }
          }
        ]
      }
    }
  ],
  "action": "overwrite"
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->patchedBody());
    }

    public function testModifyInputMetadata()
    {
        $patchResponse = <<<EOD
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
                "id": "concept1",
                "name": "concept1",
                "value": 1,
                "app_id": "@appID"
            }],
            "metadata": {
                "key1": "value1",
                "key2": {
                    "key3": true,
                    "key4": 4
                }
            }
        },
        "created_at": "2017-11-02T15:08:22.005157Z",
        "modified_at": "2017-11-02T15:08:23.071624222Z",
        "status": {
            "code": 30200,
            "description": "Input image modification success"
        }
    }]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, null, $patchResponse, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client
            ->modifyInput("@inputID", ModifyAction::overwrite())
            ->withMetadata(['key1' => 'value1', 'key2' => ['key3' => true, 'key4' => 4]])
            ->executeSync();

        # TODO(Rok) HIGH: Test special characters.

        $expectedRequestBody = <<< EOD
{
    "inputs": [
      {
        "id": "@inputID",
        "data": {
          "metadata": {
            "key1": "value1",
            "key2": {
              "key3": true,
              "key4": 4
            }
          }
        }
      }
    ],
    "action":"overwrite"
}
EOD;

        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->patchedBody());

        $this->assertTrue($response->isSuccessful());
        /** @var ClarifaiInput $input */
        $input = $response->get();
        $metadata = $input->metadata();
        $this->assertEquals(2, count($metadata));
        $this->assertEquals('value1', $metadata['key1']);
        $this->assertTrue($metadata['key2']['key3']);
        $this->assertEquals(4, $metadata['key2']['key4']);
    }

    public function testDeleteAllInputs()
    {
        $deleteResponse = '{"status":{"code":10000,"description":"Ok"}}';
        $httpClient = new FkClarifaiHttpClientTest(null, null, null, $deleteResponse);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->deleteInputs([], true)
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("/v2/inputs", $httpClient->requestedUrl());
    }

    public function testDeleteInputs()
    {
        $deleteResponse = '{"status":{"code":10000,"description":"Ok"}}';
        $httpClient = new FkClarifaiHttpClientTest(null, null, null, $deleteResponse);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->deleteInputs(["@inputID1", "@inputID2"])
            ->executeSync();

        $expectedRequestBody = <<< EOD
{
  "ids": [
    "@inputID1",
    "@inputID2"
  ]
}
EOD;

        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->deletedBody());

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals("/v2/inputs", $httpClient->requestedUrl());
    }
}
