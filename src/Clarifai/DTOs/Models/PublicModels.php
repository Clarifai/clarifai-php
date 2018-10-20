<?php
namespace Clarifai\DTOs\Models;

use Clarifai\API\ClarifaiHttpClientInterface;

/**
 * A collection of already existing models provided by the API for immediate use.
 */
class PublicModels
{
    private $colorModel;
    /**
     * Color model recognizes dominant colors on an input.
     * @return ColorModel A Color model.
     */
    public function colorModel() { return $this->colorModel; }

    private $apparelModel;
    /**
     * Apparel model recognizes clothing, accessories, ant other fashion-related items.
     * @return ConceptModel A Concept model.
     */
    public function apparelModel() { return $this->apparelModel; }

    private $foodModel;
    /**
     * Food model recognizes food items and dishes, down to the ingredient level.
     * @return ConceptModel A Concept model.
     */
    public function foodModel() { return $this->foodModel; }

    private $generalModel;
    /**
     * General model predicts most generally.
     * @return ConceptModel A Concept model.
     */
    public function generalModel() { return $this->generalModel; }

    private $landscapeQualityModel;
    /**
     * Landscape quality model predicts the quality of a landscape image.
     * @return ConceptModel A Concept model.
     */
    public function landscapeQualityModel() { return $this->landscapeQualityModel; }

    private $moderationModel;
    /**
     * Moderation model predicts inputs such as safety, gore, nudity, etc.
     * @return ConceptModel A Concept model.
     */
    public function moderationModel() { return $this->moderationModel; }

    private $nsfwModel;
    /**
     * NSFW model identifies different levels of nudity.
     * @return ConceptModel A Concept model.
     */
    public function nsfwModel() { return $this->nsfwModel; }

    private $portraitQualityModel;
    /**
     * Portrait quality model predicts the quality of a portrait image.
     * @return ConceptModel A Concept model.
     */
    public function portraitQualityModel() { return $this->portraitQualityModel; }

    private $texturesAndPatternsModel;
    /**
     * Textures & Patterns model predicts textures and patterns on an image.
     * @return ConceptModel A Concept model.
     */
    public function texturesAndPatternsModel() { return $this->texturesAndPatternsModel; }

    private $travelModel;
    /**
     * Travel model recognizes travel and hospitality-related concepts.
     * @return ConceptModel A Concept model.
     */
    public function travelModel() { return $this->travelModel; }

    private $weddingModel;
    /**
     * Wedding model recognizes wedding-related concepts bride, groom, flowers, and more.
     * @return ConceptModel A Concept model.
     */
    public function weddingModel() { return $this->weddingModel; }

    private $demographicsModel;
    /**
     * Demographics model predics the age, gender, and cultural appearance.
     * @return DemographicsModel A Demographics model.
     */
    public function demographicsModel() { return $this->demographicsModel; }

    private $generalEmbeddingModel;
    /**
     * General embedding model computes numerical embedding vectors using our General model.
     * @return EmbeddingModel An Embedding model.
     */
    public function generalEmbeddingModel() { return $this->generalEmbeddingModel; }

    private $celebrityModel;
    /**
     * Celebrity model identifies celebrities that closely resemble detected faces.
     * @return FaceConceptsModel A FaceConcepts model.
     */
    public function celebrityModel() { return $this->celebrityModel; }


    private $faceDetectionModel;
    /**
     * Face detection model detects the presence and location of human faces.
     * @return FaceDetectionModel A FaceDetection model.
     */
    public function faceDetectionModel() { return $this->faceDetectionModel; }

    private $faceEmbeddingModel;
    /**
     * Face embedding model computes numerical embedding vectors using our Face detection
     * @return FaceEmbeddingModel A FaceEmbedding model.
     */
    public function faceEmbeddingModel() { return $this->faceEmbeddingModel; }

    private $focusModel;
    /**
     * Focus model returs overall focus and identifies in-focus regions.
     * @return FocusModel A Focus model.
     */
    public function focusModel() { return $this->focusModel; }


    private $logoModel;
    /**
     * Logo model detects and identifies brand logos.
     * @return LogoModel A Logo model.
     */
    public function logoModel() { return $this->logoModel; }


    private $apparelVideoModel;
    /**
     * @return VideoModel A Video model.
     */
    public function apparelVideoModel() { return $this->apparelVideoModel; }

    private $foodVideoModel;
    /**
     * @return VideoModel A Video model.
     */
    public function foodVideoModel() { return $this->foodVideoModel; }

    private $generalVideoModel;
    /**
     * @return VideoModel A Video model.
     */
    public function generalVideoModel() { return $this->generalVideoModel; }

    private $nsfwVideoModel;
    /**
     * @return VideoModel A Video model.
     */
    public function nsfwVideoModel() { return $this->nsfwVideoModel; }

    private $travelVideoModel;
    /**
     * @return VideoModel A Video model.
     */
    public function travelVideoModel() { return $this->travelVideoModel; }

    private $weddingVideoModel;
    /**
     * @return VideoModel A Video model.
     */
    public function weddingVideoModel() { return $this->weddingVideoModel; }

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient)
    {
        $this->colorModel = new ColorModel($httpClient, 'eeed0b6733a644cea07cf4c60f87ebb7');

        $this->apparelModel = new ConceptModel($httpClient, 'e0be3b9d6a454f0493ac3a30784001ff');
        $this->foodModel = new ConceptModel($httpClient, 'bd367be194cf45149e75f01d59f77ba7');
        $this->generalModel = new ConceptModel($httpClient, 'aaa03c23b3724a16a56b629203edc62c');
        $this->landscapeQualityModel = new ConceptModel($httpClient,
            'bec14810deb94c40a05f1f0eb3c91403');
        $this->moderationModel = new ConceptModel($httpClient, 'd16f390eb32cad478c7ae150069bd2c6');
        $this->nsfwModel = new ConceptModel($httpClient, 'e9576d86d2004ed1a38ba0cf39ecb4b1');
        $this->portraitQualityModel = new ConceptModel($httpClient,
            'de9bd05cfdbf4534af151beb2a5d0953');
        $this->texturesAndPatternsModel = new ConceptModel($httpClient,
            'fbefb47f9fdb410e8ce14f24f54b47ff');
        $this->travelModel = new ConceptModel($httpClient, 'eee28c313d69466f836ab83287a54ed9');
        $this->weddingModel = new ConceptModel($httpClient, 'c386b7a870114f4a87477c0824499348');

        $this->demographicsModel = new DemographicsModel($httpClient,
            'c0c0ac362b03416da06ab3fa36fb58e3');

        $this->generalEmbeddingModel = new EmbeddingModel($httpClient,
            'bbb5f41425b8468d9b7a554ff10f8581');

        $this->celebrityModel = new FaceConceptsModel($httpClient,
            'e466caa0619f444ab97497640cefc4dc');
        $this->faceDetectionModel = new FaceDetectionModel($httpClient,
            'a403429f2ddf4b49b307e318f00e528b');

        $this->faceEmbeddingModel = new FaceEmbeddingModel($httpClient,
            'd02b4508df58432fbb84e800597b8959');

        $this->focusModel = new FocusModel($httpClient, 'c2cf7cecd8a6427da375b9f35fcd2381');

        $this->logoModel = new LogoModel($httpClient, 'c443119bf2ed4da98487520d01a0b1e3');

        $this->apparelVideoModel = new VideoModel($httpClient, 'e0be3b9d6a454f0493ac3a30784001ff');
        $this->foodVideoModel = new VideoModel($httpClient, 'bd367be194cf45149e75f01d59f77ba7');
        $this->generalVideoModel = new VideoModel($httpClient, 'aaa03c23b3724a16a56b629203edc62c');
        $this->nsfwVideoModel = new VideoModel($httpClient, 'e9576d86d2004ed1a38ba0cf39ecb4b1');
        $this->travelVideoModel = new VideoModel($httpClient, 'eee28c313d69466f836ab83287a54ed9');
        $this->weddingVideoModel = new VideoModel($httpClient, 'c386b7a870114f4a87477c0824499348');
    }
}
