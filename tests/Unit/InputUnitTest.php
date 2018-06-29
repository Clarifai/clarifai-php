<?php

namespace ClarifaiUnitTests;

use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Inputs\ModifyAction;
use Clarifai\DTOs\Predictions\Concept;
use PHPUnit\Framework\TestCase;

class InputUnitTest extends TestCase
{
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
        $inputs = $response->get();
        $this->assertEquals('@imageURL', $inputs[0]->url());
    }

    public function testModifyInputs()
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
}
