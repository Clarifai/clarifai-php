<?php

namespace Unit;

use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Predictions\Concept;
use PHPUnit\Framework\TestCase;

class SearchConceptsUnitTest extends TestCase
{
    public function testSearchConcepts()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "concepts": [
    {
      "id": "@conceptID1",
      "name": "concealer",
      "value": 1,
      "created_at": "2016-03-17T11:43:01.223962Z",
      "language": "en",
      "app_id": "main",
      "definition": "concealer"
    },
    {
      "id": "@conceptID2",
      "name": "concentrate",
      "value": 1,
      "created_at": "2016-03-17T11:43:01.223962Z",
      "language": "en",
      "app_id": "main",
      "definition": "direct one's attention on something"
    }
  ]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);

        $response = $client->searchConcepts('conc*')
            ->executeSync();

        $expectedRequestBody = <<<EOD
{
  "concept_query": {
    "name": "conc*"
  }
}
EOD;

        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());
        $this->assertTrue($response->isSuccessful());

        /** @var Concept[] $concepts */
        $concepts = $response->get();

        $this->assertEquals(2, count($concepts));

        $this->assertEquals('@conceptID1', $concepts[0]->id());
        $this->assertEquals('concealer', $concepts[0]->name());

        $this->assertEquals('@conceptID2', $concepts[1]->id());
        $this->assertEquals('concentrate', $concepts[1]->name());
    }

    public function testSearchConceptsWithLanguage()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "concepts": [
    {
      "id": "@conceptID1",
      "name": "狗",
      "value": 1,
      "created_at": "2016-03-17T11:43:01.223962Z",
      "language": "zh",
      "app_id": "main"
    },
    {
      "id": "@conceptID2",
      "name": "狗仔队",
      "value": 1,
      "created_at": "2016-03-17T11:43:01.223962Z",
      "language": "zh",
      "app_id": "main"
    },
    {
      "id": "@conceptID3",
      "name": "狗窝",
      "value": 1,
      "created_at": "2016-03-17T11:43:01.223962Z",
      "language": "zh",
      "app_id": "main"
    }
  ]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);

        $response = $client->searchConcepts('狗*')
            ->withLanguage("zh")
            ->executeSync();

        $expectedRequestBody = <<<EOD
{
  "concept_query": {
    "name": "狗*",
    "language": "zh"
  }
}
EOD;

        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());
        $this->assertTrue($response->isSuccessful());

        /** @var Concept[] $concepts */
        $concepts = $response->get();

        $this->assertEquals(3, count($concepts));

        $this->assertEquals('@conceptID1', $concepts[0]->id());
        $this->assertEquals('狗', $concepts[0]->name());

        $this->assertEquals('@conceptID2', $concepts[1]->id());
        $this->assertEquals('狗仔队', $concepts[1]->name());

        $this->assertEquals('@conceptID3', $concepts[2]->id());
        $this->assertEquals('狗窝', $concepts[2]->name());
    }
}
