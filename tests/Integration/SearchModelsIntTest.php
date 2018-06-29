<?php

namespace Integration;

use Clarifai\DTOs\Crop;
use Clarifai\DTOs\GeoPoint;
use Clarifai\DTOs\GeoRadius;
use Clarifai\DTOs\GeoRadiusUnit;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Searches\SearchBy;
use ClarifaiIntTests\BaseIntTest;

class SearchModelsIntTest extends BaseIntTest
{
    public function testSearchModelsByName()
    {
        $response = $this->client->searchModels('celeb*')
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
        $this->assertTrue(count($response->get()) > 0);
    }

    public function testSearchModelsByType()
    {
        $response = $this->client->searchModels('*', ModelType::focus())
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
        $this->assertTrue(count($response->get()) > 0);
    }
}
