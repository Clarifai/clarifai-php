<?php

namespace Integration;

use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Models\ColorModel;
use Clarifai\DTOs\Models\DemographicsModel;
use Clarifai\DTOs\Models\EmbeddingModel;
use Clarifai\DTOs\Models\FaceConceptsModel;
use Clarifai\DTOs\Models\FaceDetectionModel;
use Clarifai\DTOs\Models\FaceEmbeddingModel;
use Clarifai\DTOs\Models\FocusModel;
use Clarifai\DTOs\Models\LogoModel;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Outputs\ClarifaiOutput;
use Clarifai\DTOs\Predictions\Demographics;
use Clarifai\DTOs\Predictions\Embedding;
use Clarifai\DTOs\Predictions\FaceConcepts;
use Clarifai\DTOs\Predictions\FaceDetection;
use Clarifai\DTOs\Predictions\FaceEmbedding;
use Clarifai\DTOs\Predictions\Focus;
use Clarifai\DTOs\Predictions\Logo;

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
        $response = $this->client->getModel(ModelType::demographics(),
            $this->client->publicModels()->colorModel()->modelID())
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(10000, $response->status()->statusCode());
        $this->assertNotNull($response->rawBody());

        /* @var DemographicsModel $demographicsModel */
        $demographicsModel = $response->get();
        $this->assertNotNull($demographicsModel->modelID());
    }

    public function testPredictOnDemographicsModel()
    {
        $modelID = $this->client->publicModels()->demographicsModel()->modelID();
        $response = $this->client->predict(ModelType::demographics(), $modelID,
            new ClarifaiURLImage(parent::CELEB_IMG_URL))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        /* @var ClarifaiOutput $clarifaiOutput */
        $clarifaiOutput = $response->get();
        /* @var Demographics $demographics */
        $demographics = $clarifaiOutput->data()[0];

        $this->assertNotNull($demographics->crop());
        $this->assertNotNull($demographics->ageAppearanceConcepts());
        $this->assertNotNull($demographics->genderAppearanceConcepts());
        $this->assertNotNull($demographics->multiculturalAppearanceConcepts());
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

    public function testGetFaceConceptsModel()
    {
        $response = $this->client->getModel(ModelType::faceConcepts(),
            $this->client->publicModels()->celebrityModel()->modelID())
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(10000, $response->status()->statusCode());
        $this->assertNotNull($response->rawBody());

        /* @var FaceConceptsModel $faceConceptsModel */
        $faceConceptsModel = $response->get();
        $this->assertNotNull($faceConceptsModel->modelID());
    }

    public function testPredictOnFaceConceptsModel()
    {
        $modelID = $this->client->publicModels()->celebrityModel()->modelID();
        $response = $this->client->predict(ModelType::faceConcepts(), $modelID,
            new ClarifaiURLImage(parent::CELEB_IMG_URL))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        /* @var ClarifaiOutput $clarifaiOutput */
        $clarifaiOutput = $response->get();
        /* @var FaceConcepts $faceConcepts */
        $faceConcepts = $clarifaiOutput->data()[0];

        $this->assertNotNull($faceConcepts->crop());
        $this->assertNotNull($faceConcepts->concepts());
    }

    public function testGetFaceDetectionModel()
    {
        $response = $this->client->getModel(ModelType::faceDetection(),
            $this->client->publicModels()->faceDetectionModel()->modelID())
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(10000, $response->status()->statusCode());
        $this->assertNotNull($response->rawBody());

        /* @var FaceDetectionModel $faceDetectionModel */
        $faceDetectionModel = $response->get();
        $this->assertNotNull($faceDetectionModel->modelID());
    }

    public function testPredictOnFaceDetectionModel()
    {
        $modelID = $this->client->publicModels()->faceDetectionModel()->modelID();
        $response = $this->client->predict(ModelType::faceDetection(), $modelID,
            new ClarifaiURLImage(parent::CELEB_IMG_URL))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        /* @var ClarifaiOutput $clarifaiOutput */
        $clarifaiOutput = $response->get();
        /* @var FaceDetection $faceDetection */
        $faceDetection = $clarifaiOutput->data()[0];

        $this->assertNotNull($faceDetection->crop());
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

    public function testGetFocusModel()
    {
        $response = $this->client->getModel(ModelType::focus(),
            $this->client->publicModels()->focusModel()->modelID())
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(10000, $response->status()->statusCode());
        $this->assertNotNull($response->rawBody());

        /* @var FocusModel $faceEmbeddingModel */
        $faceEmbeddingModel = $response->get();
        $this->assertNotNull($faceEmbeddingModel->modelID());
    }

    public function testPredictOnFocusModel()
    {
        $modelID = $this->client->publicModels()->focusModel()->modelID();
        $response = $this->client->predict(ModelType::focus(), $modelID,
            new ClarifaiURLImage(parent::CELEB_IMG_URL))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        /* @var ClarifaiOutput $clarifaiOutput */
        $clarifaiOutput = $response->get();
        /* @var Focus $focus */
        $focus = $clarifaiOutput->data()[0];

        $this->assertNotNull($focus->crop());
        $this->assertNotNull($focus->value());
        $this->assertNotNull($focus->density());
    }

    public function testGetLogoModel()
    {
        $response = $this->client->getModel(ModelType::logo(),
            $this->client->publicModels()->logoModel()->modelID())
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(10000, $response->status()->statusCode());
        $this->assertNotNull($response->rawBody());

        /* @var LogoModel $logoModel */
        $logoModel = $response->get();
        $this->assertNotNull($logoModel->modelID());
        $this->assertNotNull($logoModel->outputInfo()->concepts());
    }

    public function testPredictOnLogoModel()
    {
        $modelID = $this->client->publicModels()->logoModel()->modelID();
        $response = $this->client->predict(ModelType::logo(), $modelID,
            new ClarifaiURLImage(parent::CELEB_IMG_URL))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        /* @var ClarifaiOutput $clarifaiOutput */
        $clarifaiOutput = $response->get();
        /* @var Logo $logo */
        $logo = $clarifaiOutput->data()[0];

        $this->assertNotNull($logo->crop());
        $this->assertNotNull($logo->concepts());
    }
}
