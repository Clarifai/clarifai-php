<?php

namespace Integration;

use Clarifai\DTOs\Models\ModelType;

class SearchModelsIntTest extends BaseInt
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
