<?php

namespace Unit;

use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Predictions\Concept;
use PHPUnit\Framework\TestCase;

class ConceptUnitTest extends TestCase
{

    public function testAddConcepts()
    {
        $postResponse = <<<EOD
{
    "status": {
        "code": 10000,
        "description": "Ok"
    },
    "concepts": [{
        "id": "@id1",
        "name": "@name1",
        "created_at": "2018-03-06T20:24:55.407961035Z",
        "language": "en",
        "app_id": "@appID"
    }, {
        "id": "@id1",
        "name": "@name1",
        "created_at": "2018-03-06T20:24:55.407961035Z",
        "language": "en",
        "app_id": "@appID"
    }]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client
            ->addConcepts([
                (new Concept("@id1"))->withName("@name1"),
                (new Concept("@id2"))->withName("@name2")
            ])
            ->executeSync();
        $output = $response->get();

        $expectedRequestBody = <<< EOD
{
  "concepts": [
    {
      "id": "@id1",
      "name": "@name1"
    },
    {
      "id": "@id2",
      "name": "@name2"
    }
  ]
}
EOD;

        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());
    }

    public function testGetConcept()
    {
        $getResponse = <<<EOD
{
    "status": {
        "code": 10000,
        "description": "Ok"
    },
    "concept": {
        "id": "@id",
        "name": "@name",
        "created_at": "2018-03-06T20:24:55.407961035Z",
        "language": "en",
        "app_id": "@appID"
    }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client
            ->getConcept("@concept1")
            ->executeSync();
        $concept = $response->get();
        $this->assertEquals("@id", $concept->id());
        $this->assertEquals("@name", $concept->name());
        $this->assertEquals("en", $concept->language());
    }

    public function testGetConcepts()
    {
        $getResponse = <<<EOD
{
    "status": {
        "code": 10000,
        "description": "Ok"
    },
    "concepts": [{
        "id": "@id1",
        "name": "@name1",
        "created_at": "2018-03-06T20:24:55.407961035Z",
        "language": "en",
        "app_id": "@appID"
    }, {
        "id": "@id2",
        "name": "@name2",
        "created_at": "2018-03-06T20:24:55.407961035Z",
        "language": "en",
        "app_id": "@appID"
    }]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client
            ->getConcepts()
            ->executeSync();
        $concepts = $response->get();

        $this->assertEquals("@id1", $concepts[0]->id());
        $this->assertEquals("@name1", $concepts[0]->name());
        $this->assertEquals("en", $concepts[0]->language());
        $this->assertEquals("@appID", $concepts[0]->appID());
        $this->assertEquals('2018-03-06', $concepts[0]->createdAt()->format('Y-m-d'));

        $this->assertEquals("@id2", $concepts[1]->id());
        $this->assertEquals("@name2", $concepts[1]->name());
        $this->assertEquals("en", $concepts[1]->language());
        $this->assertEquals("@appID", $concepts[1]->appID());
        $this->assertEquals('2018-03-06', $concepts[0]->createdAt()->format('Y-m-d'));
    }

    public function testModifyConcepts()
    {
        $patchResponse = <<<EOD
{
    "status": {
        "code": 10000,
        "description": "Ok"
    },
    "concepts": [{
        "id": "@id1",
        "name": "@new-name1",
        "created_at": "2018-03-06T20:24:55.407961035Z",
        "language": "en",
        "app_id": "@appID"
    }, {
        "id": "@id2",
        "name": "@new-name2",
        "created_at": "2018-03-06T20:24:55.407961035Z",
        "language": "en",
        "app_id": "@appID"
    }]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest(null, null, $patchResponse, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client
            ->modifyConcepts([
                (new Concept("@id1"))->withName("@new-name1"),
                (new Concept("@id2"))->withName("@new-name2")
            ])
            ->executeSync();
        $concepts = $response->get();

        $this->assertEquals("@id1", $concepts[0]->id());
        $this->assertEquals("@new-name1", $concepts[0]->name());
        $this->assertEquals("en", $concepts[0]->language());
        $this->assertEquals("@appID", $concepts[0]->appID());
        $this->assertEquals('2018-03-06', $concepts[0]->createdAt()->format('Y-m-d'));

        $this->assertEquals("@id2", $concepts[1]->id());
        $this->assertEquals("@new-name2", $concepts[1]->name());
        $this->assertEquals("en", $concepts[1]->language());
        $this->assertEquals("@appID", $concepts[1]->appID());
        $this->assertEquals('2018-03-06', $concepts[0]->createdAt()->format('Y-m-d'));

        $expectedRequestBody = <<< EOD
{
  "action": "overwrite",
  "concepts": [
    {
      "id": "@id1",
      "name": "@new-name1"
    },
    {
      "id": "@id2",
      "name": "@new-name2"
    }
  ]
}
EOD;

        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->patchedBody());
    }
}
