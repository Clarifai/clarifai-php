<?php

namespace Integration;

use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Models\ColorModel;
use Clarifai\DTOs\Models\DetectionModel;
use Clarifai\DTOs\Models\EmbeddingModel;
use Clarifai\DTOs\Models\FaceEmbeddingModel;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Outputs\ClarifaiOutput;
use Clarifai\DTOs\Predictions\Detection;
use Clarifai\DTOs\Predictions\Embedding;
use Clarifai\DTOs\Predictions\FaceEmbedding;

class VariousModelsIntTest extends BaseInt
{
    public function testGetColorModel()
    {
        $response = $this->client->getModel(ModelType::color(),
            $this->client->publicModels()->colorModel()->modelID())
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(10000, $response->status()->statusCode());
        $this->assertNotNull($response->rawBody());

        /* @var ColorModel $colorModel */
        $colorModel = $response->get();
        $this->assertNotNull($colorModel->modelID());
        $this->assertNotEquals(0, count($colorModel->outputInfo()->concepts()));
    }

    public function testPredictOnColorModel()
    {
        $modelID = $this->client->publicModels()->colorModel()->modelID();
        $response = $this->client->predict(ModelType::color(), $modelID,
            new ClarifaiURLImage(parent::FOCUS_IMG_URL))
            ->executeSync();
        $this->assertNotNull($response->get());
        $this->assertNotNull($response->get()->id());
        $this->assertNotNull($response->get()->data()[0]->name());
    }

    public function testGetDemographicsModel()
    {
        $response = $this->client->getModel(ModelType::detectConcept(),
            $this->client->publicModels()->demographicsModel()->modelID())
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(10000, $response->status()->statusCode());
        $this->assertNotNull($response->rawBody());

        /* @var DetectionModel $demographicsModel */
        $demographicsModel = $response->get();
        $this->assertNotNull($demographicsModel->modelID());
    }

    public function testPredictOnDemographicsModel()
    {
        $modelID = $this->client->publicModels()->demographicsModel()->modelID();
        $response = $this->client->predict(ModelType::detection(), $modelID,
            new ClarifaiURLImage(parent::CELEB_IMG_URL))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        /* @var ClarifaiOutput $clarifaiOutput */
        $clarifaiOutput = $response->get();
        /* @var Detection $demographics */
        $demographics = $clarifaiOutput->data()[0];

        $this->assertNotNull($demographics->crop());

        $this->assertNotEmpty($demographics->ageAppearanceConcepts());
        $this->assertNotEmpty($demographics->genderAppearanceConcepts());
        $this->assertNotEmpty($demographics->multiculturalAppearanceConcepts());
    }

    public function testGetEmbeddingModel()
    {
        $response = $this->client->getModel(ModelType::embedding(),
            $this->client->publicModels()->generalEmbeddingModel()->modelID())
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(10000, $response->status()->statusCode());
        $this->assertNotNull($response->rawBody());

        /* @var EmbeddingModel $embeddingModel */
        $embeddingModel = $response->get();
        $this->assertNotNull($embeddingModel->modelID());
    }

    public function testPredictOnEmbeddingModel()
    {
        $modelID = $this->client->publicModels()->generalEmbeddingModel()->modelID();
        $response = $this->client->predict(ModelType::embedding(), $modelID,
            new ClarifaiURLImage(parent::CELEB_IMG_URL))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        /* @var ClarifaiOutput $clarifaiOutput */
        $clarifaiOutput = $response->get();
        /* @var Embedding $embedding */
        $embedding = $clarifaiOutput->data()[0];

        $this->assertNotNull($embedding->type());
        $this->assertNotNull($embedding->numDimensions());
        $this->assertNotNull($embedding->vector());
    }

    public function testGetCelebrityModel()
    {
        $response = $this->client->getModel(ModelType::detectConcept(),
            $this->client->publicModels()->celebrityModel()->modelID())
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(10000, $response->status()->statusCode());
        $this->assertNotNull($response->rawBody());

        /* @var DetectionModel $faceConceptsModel */
        $faceConceptsModel = $response->get();
        $this->assertNotNull($faceConceptsModel->modelID());
    }

    public function testPredictOnCelebrityModel()
    {
        $modelID = $this->client->publicModels()->celebrityModel()->modelID();
        $response = $this->client->predict(ModelType::detectConcept(), $modelID,
            new ClarifaiURLImage(parent::CELEB_IMG_URL))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        /* @var ClarifaiOutput $clarifaiOutput */
        $clarifaiOutput = $response->get();
        /* @var Detection $detections */
        $detections = $clarifaiOutput->data()[0];

        $this->assertNotNull($detections->crop());

        $this->assertNotEmpty($detections->concepts());
    }

    public function testGetFaceDetectionModel()
    {
        $response = $this->client->getModel(ModelType::detection(),
            $this->client->publicModels()->faceDetectionModel()->modelID())
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(10000, $response->status()->statusCode());
        $this->assertNotNull($response->rawBody());

        /* @var DetectionModel $detectionModel */
        $detectionModel = $response->get();
        $this->assertNotNull($detectionModel->modelID());
    }

    public function testPredictOnFaceDetectionModel()
    {
        $modelID = $this->client->publicModels()->faceDetectionModel()->modelID();
        $response = $this->client->predict(ModelType::detectConcept(), $modelID,
            new ClarifaiURLImage(parent::CELEB_IMG_URL))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        /* @var ClarifaiOutput $clarifaiOutput */
        $clarifaiOutput = $response->get();
        /* @var Detection $detection */
        $detection = $clarifaiOutput->data()[0];

        $this->assertNotNull($detection->crop());
    }

    public function testGetFaceEmbeddingModel()
    {
        $response = $this->client->getModel(ModelType::faceEmbedding(),
            $this->client->publicModels()->faceEmbeddingModel()->modelID())
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(10000, $response->status()->statusCode());
        $this->assertNotNull($response->rawBody());

        /* @var FaceEmbeddingModel $faceEmbeddingModel */
        $faceEmbeddingModel = $response->get();
        $this->assertNotNull($faceEmbeddingModel->modelID());
    }

    public function testPredictOnFaceEmbeddingModel()
    {
        $modelID = $this->client->publicModels()->faceEmbeddingModel()->modelID();
        $response = $this->client->predict(ModelType::faceEmbedding(), $modelID,
            new ClarifaiURLImage(parent::CELEB_IMG_URL))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        /* @var ClarifaiOutput $clarifaiOutput */
        $clarifaiOutput = $response->get();
        /* @var FaceEmbedding $faceEmbedding */
        $faceEmbedding = $clarifaiOutput->data()[0];

        $this->assertNotNull($faceEmbedding->crop());
        $this->assertNotNull($faceEmbedding->embeddings()[0]->vector());
    }

    public function testGetLogoModel()
    {
        $response = $this->client->getModel(ModelType::detectConcept(),
            $this->client->publicModels()->logoModel()->modelID())
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(10000, $response->status()->statusCode());
        $this->assertNotNull($response->rawBody());

        /* @var DetectionModel $logoModel */
        $logoModel = $response->get();
        $this->assertNotNull($logoModel->modelID());
        $this->assertNotNull($logoModel->outputInfo()->concepts());
    }

    public function testPredictOnLogoModel()
    {
        $modelID = $this->client->publicModels()->logoModel()->modelID();
        $response = $this->client->predict(ModelType::detectConcept(), $modelID,
            new ClarifaiURLImage(parent::CELEB_IMG_URL))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        /* @var ClarifaiOutput $clarifaiOutput */
        $clarifaiOutput = $response->get();
        /* @var Detection $logo */
        $logo = $clarifaiOutput->data()[0];

        $this->assertNotNull($logo->crop());
        $this->assertNotNull($logo->concepts());
    }
}
