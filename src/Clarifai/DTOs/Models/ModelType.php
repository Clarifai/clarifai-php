<?php

namespace Clarifai\DTOs\Models;

use Clarifai\DTOs\Predictions\Color;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\DTOs\Predictions\Demographics;
use Clarifai\DTOs\Predictions\Embedding;
use Clarifai\DTOs\Predictions\FaceConcepts;
use Clarifai\DTOs\Predictions\FaceDetection;
use Clarifai\DTOs\Predictions\FaceEmbedding;
use Clarifai\DTOs\Predictions\Focus;
use Clarifai\DTOs\Predictions\Frame;
use Clarifai\DTOs\Predictions\Logo;

class ModelType
{
    private $typeExt;

    public function typeExt() { return $this->typeExt; }

    private $model;

    private $prediction;
    /**
     * @return string The prediction class name.
     */
    public function prediction() { return $this->prediction; }

    /**
     * Ctor.
     * @param string $typeExt The type ext that uniquely defines a model type.
     * @param string $model The model class name.
     * @param string $prediction The prediction class name.
     */
    private function __construct($typeExt, $model, $prediction)
    {
        $this->typeExt = $typeExt;
        $this->model = $model;
        $this->prediction = $prediction;
    }

    public static function color()
    {
        return new ModelType('color', ColorModel::class, Color::class);
    }

    public static function concept()
    {
        return new ModelType('concept', ConceptModel::class, Concept::class);
    }

    public static function demographics()
    {
        return new ModelType('facedetect-demographics', DemographicsModel::class,
            Demographics::class);
    }

    public static function embedding()
    {
        return new ModelType('embed', EmbeddingModel::class, Embedding::class);
    }

    public static function faceConcepts()
    {
        return new ModelType('facedetect-identity', FaceConceptsModel::class, FaceConcepts::class);
    }

    public static function faceDetection()
    {
        return new ModelType('facedetect', FaceDetectionModel::class, FaceDetection::class);
    }

    public static function faceEmbedding()
    {
        return new ModelType('detect-embed', FaceEmbeddingModel::class, FaceEmbedding::class);
    }

    public static function focus()
    {
        return new ModelType('focus', FocusModel::class, Focus::class);
    }

    public static function logo()
    {
        return new ModelType('detection', LogoModel::class, Logo::class);
    }

    public static function video()
    {
        return new ModelType('video', VideoModel::class, Frame::class);
    }

    /**
     * Determines the ModelType belonging to the $typeExt parameter.
     * @param string $typeExt The type ext which uniquely defines a model type.
     * @return ModelType|null The ModelType instance.
     */
    public static function determineModelType($typeExt)
    {
        $allModelTypes = [
            self::color(),
            self::concept(),
            self::demographics(),
            self::embedding(),
            self::faceConcepts(),
            self::faceDetection(),
            self::faceEmbedding(),
            self::focus(),
            self::logo(),
        ];
        foreach ($allModelTypes as $modelType) {
            if ($modelType->typeExt() == $typeExt) {
                return $modelType;
            }
        }
        return null;
    }

    public function __toString()
    {
        return $this->typeExt;
    }
}
