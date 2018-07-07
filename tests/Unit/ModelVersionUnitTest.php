<?php

namespace Unit;

use Clarifai\API\ClarifaiClient;
use PHPUnit\Framework\TestCase;

class ModelVersionUnitTest extends TestCase
{
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
