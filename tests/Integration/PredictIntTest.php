<?php

namespace Integration;

use Clarifai\DTOs\Crop;
use Clarifai\DTOs\Inputs\ClarifaiFileImage;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Inputs\ClarifaiURLVideo;
use Clarifai\DTOs\Models\ConceptModel;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Predictions\Concept;

class PredictIntTest extends BaseInt
{
    public function testPredictURLImage()
    {
        $modelID = $this->client->publicModels()->moderationModel()->modelID();
        $response = $this->client->predict(ModelType::concept(), $modelID,
            new ClarifaiURLImage(parent::FOCUS_IMG_URL))
            ->executeSync();
        $this->assertNotNull($response->get());
        $this->assertNotNull($response->get()->id());
        $this->assertNotNull($response->get()->data()[0]->name());
    }

    public function testPredictURLImageWithCrop()
    {
        $modelID = $this->client->publicModels()->moderationModel()->modelID();
        $response = $this->client->predict(ModelType::concept(), $modelID,
            (new ClarifaiURLImage(parent::FOCUS_IMG_URL))
            ->withCrop(new Crop(0.1, 0.2, 0.3, 0.4)))
            ->executeSync();
        $this->assertNotNull($response->get());
        $this->assertNotNull($response->get()->id());
        $this->assertNotNull($response->get()->data()[0]->name());
    }

    public function testPredictURLImageWithModelVersion()
    {
        $modelID = $this->client->publicModels()->moderationModel()->modelID();


        $getModelResponse = $this->client
            ->getModel(ModelType::color(), $modelID)
            ->executeSync();
        /** @var ConceptModel $model */
        $model = $getModelResponse->get();

        $modelVersionID = $model->modelVersion()->id();

        $response = $this->client->predict(ModelType::concept(), $modelID,
            new ClarifaiURLImage(parent::FOCUS_IMG_URL))
            ->withModelVersionID($modelVersionID)
            ->executeSync();
        $this->assertNotNull($response->get());
        $this->assertNotNull($response->get()->id());
        $this->assertNotNull($response->get()->data()[0]->name());
    }

    public function testPredictURLImageWithMinValue()
    {
        $modelID = $this->client->publicModels()->moderationModel()->modelID();

        $response = $this->client->predict(ModelType::concept(), $modelID,
            new ClarifaiURLImage(parent::FOCUS_IMG_URL))
            ->withMinValue(0.95)
            ->executeSync();
        $this->assertNotNull($response->get());
        $this->assertNotNull($response->get()->id());
        $this->assertNotNull($response->get()->data()[0]->name());

        foreach ($response->get()->data() as $concept) {
            $this->assertGreaterThanOrEqual(0.95, $concept->value());
        }
    }

    public function testPredictURLImageWithMaxConcepts()
    {
        $modelID = $this->client->publicModels()->moderationModel()->modelID();

        $response = $this->client->predict(ModelType::concept(), $modelID,
            new ClarifaiURLImage(parent::FOCUS_IMG_URL))
            ->withMaxConcepts(3)
            ->executeSync();
        $this->assertNotNull($response->get());
        $this->assertNotNull($response->get()->id());
        $this->assertNotNull($response->get()->data()[0]->name());

        $this->assertLessThanOrEqual(3, count($response->get()->data()));
    }

    public function testPredictURLImageWithSelectConcepts()
    {
        $dogConceptID = 'ai_mFqxrph2';
        $catConceptID = 'ai_8S2Vq3cR';

        $modelID = $this->client->publicModels()->generalModel()->modelID();

        $response = $this->client->predict(ModelType::concept(), $modelID,
            new ClarifaiURLImage(parent::FOCUS_IMG_URL))
            ->withSelectConcepts([new Concept($dogConceptID), new Concept($catConceptID)])
            ->executeSync();

        $this->assertTrue($response->isSuccessful());

        $this->assertNotNull($response->get());
        $this->assertNotNull($response->get()->id());
        $this->assertNotNull($response->get()->data()[0]->name());

        $this->assertEquals(2, count($response->get()->data()));

        $conceptIDs = [];
        foreach ($response->get()->data() as $concept) {
            array_push($conceptIDs, $concept->id());
        }
        $this->assertContains($dogConceptID, $conceptIDs);
        $this->assertContains($catConceptID, $conceptIDs);
    }

    public function testPredictFileImage()
    {
        $base64 = file_get_contents(parent::BALLOONS_FILE_PATH);

        $modelID = $this->client->publicModels()->moderationModel()->modelID();
        $response = $this->client->predict(ModelType::concept(), $modelID,
            new ClarifaiFileImage($base64))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->get());
        $this->assertNotNull($response->get()->id());
        $this->assertNotNull($response->get()->data()[0]->name());
    }

    public function testPredictURLVideo()
    {
        $this->markTestSkipped('Video is WIP');

        $modelID = $this->client->publicModels()->moderationModel()->modelID();
        $response = $this->client->predict(ModelType::concept(), $modelID,
            new ClarifaiURLVideo(parent::GIF_VIDEO_URL))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->get());
        $this->assertNotNull($response->get()->id());
        $this->assertNotNull($response->get()->data()[0]->name());
    }

    public function testBatchPredictURLImage()
    {
        $modelID = $this->client->publicModels()->moderationModel()->modelID();
        $response = $this->client->batchPredict(ModelType::concept(), $modelID,
            [new ClarifaiURLImage(parent::CELEB_IMG_URL),
                new ClarifaiURLImage(parent::FOCUS_IMG_URL)])
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->get());
        $this->assertNotNull($response->get()[0]->id());

        $this->assertEquals(2, count($response->get()));

        $this->assertNotNull($response->get()[0]->data()[0]->id());
        $this->assertNotNull($response->get()[0]->data()[0]->name());
        $this->assertNotNull($response->get()[0]->data()[1]->id());
        $this->assertNotNull($response->get()[0]->data()[1]->name());

        $this->assertTrue($response->isSuccessful());
    }

    public function testBatchPredictURLImageWithModelVersion()
    {
        $modelID = $this->client->publicModels()->moderationModel()->modelID();


        $getModelResponse = $this->client
            ->getModel(ModelType::color(), $modelID)
            ->executeSync();
        /** @var ConceptModel $model */
        $model = $getModelResponse->get();

        $modelVersionID = $model->modelVersion()->id();

        $response = $this->client->batchPredict(ModelType::concept(), $modelID,
            [new ClarifaiURLImage(parent::CELEB_IMG_URL),
                new ClarifaiURLImage(parent::FOCUS_IMG_URL)])
            ->withModelVersionID($modelVersionID)
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->get());
        $this->assertNotNull($response->get()[0]->id());
        $this->assertNotNull($response->get()[0]->data()[0]->name());
    }

    public function testBatchPredictURLImageWithMinValue()
    {
        $modelID = $this->client->publicModels()->moderationModel()->modelID();

        $response = $this->client->batchPredict(ModelType::concept(), $modelID,
            [new ClarifaiURLImage(parent::CELEB_IMG_URL),
                new ClarifaiURLImage(parent::FOCUS_IMG_URL)])
            ->withMinValue(0.95)
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->get());
        $this->assertNotNull($response->get()[0]->id());
        $this->assertNotNull($response->get()[0]->data()[0]->name());

        foreach ($response->get()[0]->data() as $concept) {
            $this->assertGreaterThanOrEqual(0.95, $concept->value());
        }
    }

    public function testBatchPredictURLImageWithMaxConcepts()
    {
        $modelID = $this->client->publicModels()->moderationModel()->modelID();

        $response = $this->client->batchPredict(ModelType::concept(), $modelID,
            [new ClarifaiURLImage(parent::CELEB_IMG_URL),
                new ClarifaiURLImage(parent::FOCUS_IMG_URL)])
            ->withMaxConcepts(3)
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->get());
        $this->assertNotNull($response->get()[0]->id());
        $this->assertNotNull($response->get()[0]->data()[0]->name());

        $this->assertLessThanOrEqual(3, count($response->get()[0]->data()));
    }

    public function testBatchPredictURLImageWithSelectConcepts()
    {
        $dogConceptID = 'ai_mFqxrph2';
        $catConceptID = 'ai_8S2Vq3cR';

        $modelID = $this->client->publicModels()->generalModel()->modelID();

        $response = $this->client->batchPredict(ModelType::concept(), $modelID,
            [new ClarifaiURLImage(parent::CELEB_IMG_URL),
                new ClarifaiURLImage(parent::FOCUS_IMG_URL)])
            ->withSelectConcepts([new Concept($dogConceptID), new Concept($catConceptID)])
            ->executeSync();

        $this->assertTrue($response->isSuccessful());

        $this->assertNotNull($response->get());
        $this->assertNotNull($response->get()[0]->id());
        $this->assertNotNull($response->get()[0]->data()[0]->name());

        $this->assertEquals(2, count($response->get()[0]->data()));

        $conceptIDs = [];
        foreach ($response->get()[0]->data() as $concept) {
            array_push($conceptIDs, $concept->id());
        }
        $this->assertContains($dogConceptID, $conceptIDs);
        $this->assertContains($catConceptID, $conceptIDs);
    }
}
