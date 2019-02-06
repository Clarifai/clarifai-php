<?php

namespace Unit;

use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Crop;
use Clarifai\DTOs\Feedbacks\ConceptFeedback;
use Clarifai\DTOs\Feedbacks\Feedback;
use Clarifai\DTOs\Feedbacks\RegionFeedback;
use PHPUnit\Framework\TestCase;

class FeedbackUnitTest extends TestCase
{

    public function testModelFeedback()
    {
        $postResponse = '{"status":{"code":10000,"description":"Ok"}}';
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->modelFeedback(
            '@modelID', '@imageURL', '@inputID', '@outputID', '@endUserID', '@sessionID')
            ->withConceptFeedbacks([
                new ConceptFeedback('dog', true),
                new ConceptFeedback('cat', false)
            ])
            ->withRegionFeedbacks([
                (new RegionFeedback())
                    ->withCrop(new Crop(0.1, 0.1, 0.2, 0.2))
                    ->withFeedback(Feedback::notDetected())
                    ->withConceptFeedbacks([
                        new ConceptFeedback("freeman", true),
                        new ConceptFeedback("eminem", false),
                    ])
            ])
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        $expectedRequestBody = <<<EOD
{
  "input": {
    "id": "@inputID",
    "data": {
      "image": {
        "url": "@imageURL"
      },
      "concepts": [
        {
          "id": "dog",
          "value": true
        },
        {
          "id": "cat",
          "value": false
        }
      ],
      "regions": [
        {
          "region_info": {
            "bounding_box": {
              "top_row": 0.1,
              "left_col": 0.1,
              "bottom_row": 0.2,
              "right_col": 0.2
            },
            "feedback": "not_detected"
          },
          "data": {
            "concepts": [
              {
                "id": "freeman",
                "value": true
              },
              {
                "id": "eminem",
                "value": false
              }
            ]
          }
        }
      ]
    },
    "feedback_info": {
      "end_user_id": "@endUserID",
      "session_id": "@sessionID",
      "event_type": "annotation",
      "output_id": "@outputID"
    }
  }
}
EOD;

        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());
    }

    public function testSearchesFeedback()
    {
        $postResponse = '{"status":{"code":10000,"description":"Ok"}}';
        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->searchesFeedback("@inputID", "@searchID", "@endUserID", "@sessionID")
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        $expectedRequestBody = <<<EOD
{
    "input": {
        "id": "@inputID",
        "feedback_info": {
            "event_type":   "search_click",
            "search_id":    "@searchID",
            "end_user_id":  "@endUserID",
            "session_id":   "@sessionID"
        }
    }
}
EOD;

        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());
    }
}
