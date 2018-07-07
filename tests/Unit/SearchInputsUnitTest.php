<?php

namespace Unit;

use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\GeoPoint;
use Clarifai\DTOs\GeoRadius;
use Clarifai\DTOs\GeoRadiusUnit;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Inputs\InputForm;
use Clarifai\DTOs\Inputs\InputType;
use Clarifai\DTOs\Searches\SearchBy;
use Clarifai\DTOs\Searches\SearchInputsResult;
use PHPUnit\Framework\TestCase;

class SearchInputsUnitTest extends TestCase
{
    public function testSearchInputsByID()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "hits": [
    {
      "score": 0.99,
      "input": {
        "id": "@inputID",
        "created_at": "2016-11-22T17:06:02Z",
        "data": {
          "image": {
            "url": "@inputURL"
          }
        },
        "status": {
          "code": 30000,
          "description": "Download complete"
        }
      }
    }
  ]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);

        $response = $client->searchInputs(SearchBy::conceptID('@conceptID'))
            ->executeSync();

        $expectedRequestBody = <<<EOD
{
  "query": {
    "ands": [
      {
        "output": {
          "data": {
            "concepts": [
              {
                "id": "@conceptID"
              }
            ]
          }
        }
      }
    ]
  }
}
EOD;

        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());
        $this->assertTrue($response->isSuccessful());

        /** @var SearchInputsResult $searchInputsResult */
        $searchInputsResult = $response->get();

        $searchHits = $searchInputsResult->searchHits();

        $this->assertEquals(1, count($searchHits));

        /** @var ClarifaiURLImage $input */
        $input = $searchHits[0]->input();

        $this->assertEquals('@inputID', $input->id());
        $this->assertEquals(InputType::image(), $input->type());
        $this->assertEquals(InputForm::url(), $input->form());
        $this->assertEquals('@inputURL', $input->URL());
    }

    public function testSearchInputsByName()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "hits": [
    {
      "score": 0.99,
      "input": {
        "id": "@inputID",
        "created_at": "2016-11-22T17:06:02Z",
        "data": {
          "image": {
            "url": "@inputURL"
          }
        },
        "status": {
          "code": 30000,
          "description": "Download complete"
        }
      }
    }
  ]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);

        $response = $client->searchInputs(SearchBy::conceptName('@conceptName'))
            ->executeSync();

        $expectedRequestBody = <<<EOD
{
  "query": {
    "ands": [
      {
        "output": {
          "data": {
            "concepts": [
              {
                "name": "@conceptName"
              }
            ]
          }
        }
      }
    ]
  }
}
EOD;

        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());
        $this->assertTrue($response->isSuccessful());

        /** @var SearchInputsResult $searchInputsResult */
        $searchInputsResult = $response->get();

        $searchHits = $searchInputsResult->searchHits();

        $this->assertEquals(1, count($searchHits));

        /** @var ClarifaiURLImage $input */
        $input = $searchHits[0]->input();

        $this->assertEquals('@inputID', $input->id());
        $this->assertEquals(InputType::image(), $input->type());
        $this->assertEquals(InputForm::url(), $input->form());
        $this->assertEquals('@inputURL', $input->URL());
    }

    public function testSearchInputsByGeoLocation()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "hits": [
    {
      "score": 0.99,
      "input": {
        "id": "@inputID",
        "created_at": "2016-11-22T17:06:02Z",
        "data": {
          "image": {
            "url": "@inputURL"
          }
        },
        "status": {
          "code": 30000,
          "description": "Download complete"
        }
      }
    }
  ]
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);

        $response = $client->searchInputs(SearchBy::geoCircle(
                new GeoPoint(1.5, -1), new GeoRadius(1, GeoRadiusUnit::withinKilometers())))
            ->executeSync();

        $expectedRequestBody = <<<EOD
{
  "query": {
    "ands": [
      {
        "input": {
          "data": {
            "geo": {
              "geo_point": {
                "longitude": 1.5,
                "latitude": -1.0
              },
              "geo_limit": {
                "type": "withinKilometers",
                "value": 1.0
              }
            }
          }
        }
      }
    ]
  }
}
EOD;

        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());
        $this->assertTrue($response->isSuccessful());

        /** @var SearchInputsResult $searchInputsResult */
        $searchInputsResult = $response->get();

        $searchHits = $searchInputsResult->searchHits();

        $this->assertEquals(1, count($searchHits));

        /** @var ClarifaiURLImage $input */
        $input = $searchHits[0]->input();

        $this->assertEquals('@inputID', $input->id());
        $this->assertEquals(InputType::image(), $input->type());
        $this->assertEquals(InputForm::url(

        ), $input->form());
        $this->assertEquals('@inputURL', $input->URL());
    }
}
