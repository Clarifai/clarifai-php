<?php

namespace Unit;

use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Feedbacks\ConceptFeedback;
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
            ])->executeSync();
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
            ]
        },
        "feedback_info": {
            "event_type": "annotation",
            "output_id": "@outputID",
            "end_user_id": "@endUserID",
            "session_id": "@sessionID"
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
