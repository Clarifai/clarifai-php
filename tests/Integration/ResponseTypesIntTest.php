<?php

namespace Integration;

use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\StatusType;

class ResponseTypesIntTest extends BaseInt
{
    public function testSuccessfulResponse()
    {
        $modelID = $this->client->publicModels()->generalModel()->modelID();
        $response = $this->client->predict(ModelType::concept(), $modelID,
            new ClarifaiURLImage(parent::CELEB_IMG_URL))
            ->executeSync();

        $this->assertEquals(StatusType::successful(), $response->status()->type());
    }

    public function testFailureResponse()
    {
        $modelID = $this->client->publicModels()->generalModel()->modelID();
        $response = $this->client->predict(ModelType::concept(), $modelID,
            new ClarifaiURLImage('https://clarifai.com/non-existing-img-321231.jpg'))
            ->executeSync();

        $this->assertEquals(StatusType::failure(), $response->status()->type());
    }

    # TODO (Rok) HIGH: Add tests for handling mixed responses.
}
