<?php

namespace Unit;

use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Models\ConceptModel;
use Clarifai\DTOs\Models\ModelVersion;
use PHPUnit\Framework\TestCase;

class ModelVersionUnitTest extends TestCase
{
    public function testGetModelVersion()
    {
        $getResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "model_version": {
    "id": "@modelVersionID",
    "created_at": "2017-10-31T16:30:31.226185Z",
    "status": {
      "code": 21100,
      "description": "Model trained successfully"
    },
    "active_concept_count": 5,
    "train_stats": {}
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getModelVersion('@modelID', '@modelVersionID')->executeSync();
        $this->assertTrue($response->isSuccessful());

        $this->assertEquals(
            '/v2/models/@modelID/versions/@modelVersionID', $httpClient->requestedUrl());

        /** @var ModelVersion $modelVersion */
        $modelVersion = $response->get();
        $this->assertEquals('@modelVersionID', $modelVersion->id());
        $this->assertEquals(5, $modelVersion->activeConceptCount());
    }

    public function testGetModelVersions()
    {
        $getResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "model_versions": [
    {
      "id": "@modelVersionID1",
      "created_at": "2017-10-31T16:30:31.226185Z",
      "status": {
        "code": 21100,
        "description": "Model trained successfully"
      },
      "active_concept_count": 5,
      "train_stats": {}
    },
    {
      "id": "@modelVersionID2",
      "created_at": "2017-05-16T19:20:38.733764Z",
      "status": {
        "code": 21100,
        "description": "Model trained successfully"
      },
      "active_concept_count": 5,
      "train_stats": {}
    }
  ]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getModelVersions('@modelID')->executeSync();
        $this->assertTrue($response->isSuccessful());

        $this->assertEquals(
            '/v2/models/@modelID/versions', $httpClient->requestedUrl());

        /** @var ModelVersion[] $modelVersions */
        $modelVersions = $response->get();

        $this->assertEquals('@modelVersionID1', $modelVersions[0]->id());
        $this->assertEquals(5, $modelVersions[0]->activeConceptCount());

        $this->assertEquals('@modelVersionID2', $modelVersions[1]->id());
        $this->assertEquals(5, $modelVersions[1]->activeConceptCount());
    }

    public function testDeleteModelVersion()
    {
        $deleteResponse = '{"status": {"code": 10000, "description": "Ok"}}';
        $httpClient = new FkClarifaiHttpClientTest(null, null, null, $deleteResponse);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->deleteModelVersion('@modelID', '@modelVersionID')->executeSync();
        $this->assertTrue($response->isSuccessful());

        $this->assertEquals('Ok', $response->status()->description());
    }
}
