<?php

namespace Integration;

use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Inputs\ModifyAction;
use Clarifai\DTOs\Models\ConceptModel;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Models\OutputInfos\FaceConceptsOutputInfo;
use Clarifai\DTOs\Predictions\Concept;

class ModelIntTest extends BaseInt
{
    public function testCreateModifyGetAndDeleteModel()
    {
        $modelID = $this->generateRandomID();

        // This will fail if the model doesn't exist, but it's fine at this point
        $this->client->deleteModel($modelID)->executeSync();

        try {
            /**
             * Create a new model.
             */
            $createResponse = $this->client->createModel($modelID)
                ->withConcepts([new Concept('dog'), new Concept('cat')])
                ->withName('original-name')
                ->withAreConceptsMutuallyExclusive(false)
                ->withIsEnvironmentClosed(false)
                ->executeSync();
            $this->assertTrue($createResponse->isSuccessful());

            $this->assertEquals($modelID, $createResponse->get()->modelID());

            /**
             * Modify the model.
             */
            $modifyResponse = $this->client->modifyModel($modelID)
                ->withModifyAction(ModifyAction::overwrite())
                ->withName('new-name')
                ->withConcepts([new Concept('horse'), new Concept('bird')])
                ->withAreConceptsMutuallyExclusive(true)
                ->withIsEnvironmentClosed(true)
                ->executeSync();

            $this->assertTrue($modifyResponse->isSuccessful());
            $this->assertEquals($modelID, $modifyResponse->get()->modelID());
            $this->assertEquals('new-name', $modifyResponse->get()->name());
            $this->assertTrue($modifyResponse->get()->outputInfo()->areConceptsMutuallyExclusive());
            $this->assertTrue($modifyResponse->get()->outputInfo()->isEnvironmentClosed());

            /**
             * Get the model to ensure the fields were changed.
             */
            $getResponse = $this->client->getModel(ModelType::concept(), $modelID)->executeSync();

            $this->assertTrue($getResponse->isSuccessful());
            $this->assertEquals($modelID, $getResponse->get()->modelID());
            $this->assertEquals('new-name', $getResponse->get()->name());
            $this->assertTrue($getResponse->get()->outputInfo()->areConceptsMutuallyExclusive());
            $this->assertTrue($getResponse->get()->outputInfo()->isEnvironmentClosed());
            $conceptIDs = array_map(
                function($c) { return $c->id(); },
                $getResponse->get()->outputInfo()->concepts());
            $this->assertContains('horse', $conceptIDs);
            $this->assertContains('bird', $conceptIDs);
        } finally {
            $deleteResponse = $this->client->deleteModel($modelID)->executeSync();
            $this->assertTrue($deleteResponse->isSuccessful());
        }
    }

    public function testCreateGetAndDeleteFaceConceptsModel()
    {
        $modelID = $this->generateRandomID();

        // This will fail if the model doesn't exist, but it's fine at this point
        $this->client->deleteModel($modelID)->executeSync();

        try {
            /**
             * Create a new model.
             */
            $createResponse = $this->client->createModelGeneric($modelID)
                ->withName('original-name')
                ->withOutputInfo((FaceConceptsOutputInfo::make(
                    [new Concept('dog'), new Concept('cat')], true, true, 'en')))
                ->executeSync();
            $this->assertTrue($createResponse->isSuccessful());

            $this->assertEquals($modelID, $createResponse->get()->modelID());

            /**
             * Get the model.
             */
            $getResponse = $this->client->getModel(ModelType::faceConcepts(), $modelID)
                ->executeSync();

            $this->assertTrue($getResponse->isSuccessful());
            $this->assertEquals($modelID, $getResponse->get()->modelID());
            $this->assertEquals('original-name', $getResponse->get()->name());
            $this->assertTrue($getResponse->get()->outputInfo()->areConceptsMutuallyExclusive());
            $this->assertTrue($getResponse->get()->outputInfo()->isEnvironmentClosed());
            $conceptIDs = array_map(
                function($c) { return $c->id(); },
                $getResponse->get()->outputInfo()->concepts());
            $this->assertContains('dog', $conceptIDs);
            $this->assertContains('cat', $conceptIDs);
        } finally {
            $deleteResponse = $this->client->deleteModel($modelID)->executeSync();
            $this->assertTrue($deleteResponse->isSuccessful());
        }
    }
    public function testGetModels()
    {
        $response = $this->client->getModels()->executeSync();
        $this->assertTrue($response->isSuccessful());
    }

    public function testDeleteAllModels()
    {
        $response = $this->client->deleteAllModels()->executeSync();
        $this->assertTrue($response->isSuccessful());
    }

    public function testTrainModel()
    {
        $modelID = 'test-model-to-train';

        try {
            /**
             * Create a new model.
             */
            $createResponse = $this->client->createModel($modelID)
                ->withConcepts([new Concept('celeb'), new Concept('focus')])
                ->executeSync();
            $this->assertTrue($createResponse->isSuccessful());

            /** @var ConceptModel $model */
            $model = $createResponse->get();

            /*
             * Add inputs associated with concepts.
             */
            $addInputsResponse = $this->client->addInputs([
                (new ClarifaiURLImage(parent::CELEB_IMG_URL))
                    ->withAllowDuplicateUrl(true)
                    ->withPositiveConcepts([new Concept('celeb')]),
                (new ClarifaiURLImage(parent::FOCUS_IMG_URL))
                    ->withAllowDuplicateUrl(true)
                    ->withPositiveConcepts([new Concept('focus')]),
            ])->executeSync();
            $this->assertTrue($addInputsResponse->isSuccessful());

            /*
             * Train the model.
             */
            $trainResponse = $model->train()->executeSync();
            $this->assertTrue($trainResponse->isSuccessful());
        } finally {
            $deleteResponse = $this->client->deleteModel($modelID)->executeSync();
            $this->assertTrue($deleteResponse->isSuccessful());
        }
    }
}
