<?php

namespace Clarifai\DTOs\Models;

use Clarifai\DTOs\Predictions\Color;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\DTOs\Predictions\Demographics;
use Clarifai\DTOs\Predictions\Detection;
use Clarifai\DTOs\Predictions\Embedding;
use Clarifai\DTOs\Predictions\FaceEmbedding;
use Clarifai\DTOs\Predictions\Focus;
use Clarifai\DTOs\Predictions\Frame;

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

    public static function detectConcept()
    {
        return new ModelType('detect-concept', DetectionModel::class, Detection::class);
    }

    public static function detection()
    {
        return new ModelType('detection', DetectionModel::class, Detection::class);
    }

    public static function embedding()
    {
        return new ModelType('embed', EmbeddingModel::class, Embedding::class);
    }

    public static function faceEmbedding()
    {
        return new ModelType('detect-embed', FaceEmbeddingModel::class, FaceEmbedding::class);
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
            self::detectConcept(),
            self::detection(),
            self::embedding(),
            self::faceEmbedding(),
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
