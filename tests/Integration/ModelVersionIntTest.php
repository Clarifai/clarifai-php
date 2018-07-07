<?php

namespace Integration;

use Clarifai\DTOs\Models\Model;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Models\ModelVersion;

class ModelVersionIntTest extends BaseInt
{
    public function testGetModelVersion()
    {
        $modelID = $this->client->publicModels()->moderationModel()->modelID();
        $getModelResponse = $this->client->getModel(ModelType::concept(), $modelID)->executeSync();

        /** @var Model $model */
        $model = $getModelResponse->get();

        $response = $this->client->getModelVersion($modelID, $model->modelVersion()->id())
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($model->modelVersion()->id(), $response->get()->id());
    }

    public function testShorthandGetModelVersion()
    {
        $modelID = $this->client->publicModels()->moderationModel()->modelID();
        $getModelResponse = $this->client->getModel(ModelType::concept(), $modelID)->executeSync();

        /** @var Model $model */
        $model = $getModelResponse->get();

        $response = $model->getModelVersion($model->modelVersion()->id())
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        /** @var ModelVersion $modelVersion */
        $modelVersion = $response->get();

        $this->assertEquals($model->modelVersion()->id(), $modelVersion->id());
    }

    public function testGetModelVersions()
    {
        $modelID = $this->client->publicModels()->moderationModel()->modelID();

        $response = $this->client->getModelVersions($modelID)
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        $modelVersions = $response->get();
        $this->assertNotNull($modelVersions);
        $this->assertNotEquals(0, count($modelVersions));
    }

    public function testShorthandGetModelVersions()
    {
        $modelID = $this->client->publicModels()->moderationModel()->modelID();
        $getModelResponse = $this->client->getModel(ModelType::concept(), $modelID)->executeSync();

        /** @var Model $model */
        $model = $getModelResponse->get();

        $response = $model->getModelVersions()
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        $modelVersions = $response->get();
        $this->assertNotNull($modelVersions);
        $this->assertNotEquals(0, count($modelVersions));
    }

    public function testDeleteModelVersion()
    {
        $modelID = $this->generateRandomID();

        $createResponse = $this->client->createModel($modelID)->executeSync();
        $this->assertTrue($createResponse->isSuccessful());

        try {
            /** @var Model $model */
            $model = $createResponse->get();

            $modelVersionID = $model->modelVersion()->id();

            $deleteModelVersionResponse = $this->client->deleteModelVersion($modelID,
                    $modelVersionID)
                ->executeSync();

            $this->assertTrue($deleteModelVersionResponse->isSuccessful());

            /*
             * The model version should not exist anymore.
             */
            $getModelResponse2 = $this->client->getModelVersion($modelID, $modelVersionID)
                ->executeSync();
            $this->assertFalse($getModelResponse2->isSuccessful());
        } finally {
            $this->client->deleteModel($modelID)
                ->executeSync();
        }
    }

    public function testShorthandDeleteModelVersion()
    {
        $modelID = $this->generateRandomID();

        $createResponse = $this->client->createModel($modelID)->executeSync();
        $this->assertTrue($createResponse->isSuccessful());

        try {
            /** @var Model $model */
            $model = $createResponse->get();

            $modelVersionID = $model->modelVersion()->id();

            $deleteModelVersionResponse = $model->deleteModelVersion($modelVersionID)
                ->executeSync();

            $this->assertTrue($deleteModelVersionResponse->isSuccessful());

            /*
             * The model version should not exist anymore.
             */
            $getModelResponse2 = $this->client->getModelVersion($modelID, $modelVersionID)
                ->executeSync();
            $this->assertFalse($getModelResponse2->isSuccessful());
        } finally {
            $this->client->deleteModel($modelID)
                ->executeSync();
        }
    }
}
