<?php

namespace Clarifai\DTOs\Inputs;

use Clarifai\DTOs\GeoPoint;
use Clarifai\Grpc\Image;
use Clarifai\Grpc\Input;
use Clarifai\DTOs\Crop;
use Clarifai\DTOs\Predictions\Concept;

/**
 * An image at a certain URL.
 */
class ClarifaiURLImage extends ClarifaiInput
{
    private $url;
    public function url() { return $this->url; }

    private $allowDuplicateUrl;
    public function allowDuplicateUrl() { return $this->allowDuplicateUrl; }
    public function withAllowDuplicateUrl($val) { $this->allowDuplicateUrl = $val; return $this; }

    /**
     * @var Crop The crop.
     */
    private $crop;
    /**
     * @return Crop The crop.
     */
    public function crop() { return $this->crop; }
    /**
     * @param Crop $val The crop.
     * @return $this
     */
    public function withCrop($val) { $this->crop = $val; return $this; }

    /**
     * Ctor.
     * @param string $url the URL of the image
     */
    public function __construct($url)
    {
        parent::__construct(InputType::image(), InputForm::url());
        $this->url = $url;
    }

    /**
     * @return \Clarifai\Grpc\Input
     */
    public function serialize()
    {
        $image = (new \Clarifai\Grpc\Image())
            ->setUrl($this->url);
        if (!is_null($this->crop)) {
            $image->setCrop($this->crop->serializeAsArray());
        }
        if (!is_null($this->allowDuplicateUrl)) {
            $image->setAllowDuplicateUrl($this->allowDuplicateUrl);
        }
        return parent::serializeInner('image', $image);
    }

    /**
     * @param \Clarifai\Grpc\Input $imageResponse
     * @return ClarifaiURLImage
     */
    public static function deserialize($imageResponse)
    {
        $positiveConcepts = [];
        $negativeConcepts = [];
        foreach ($imageResponse->getData()->getConcepts() as $c)
        {
            $concept = Concept::deserialize($c);
            if ($concept->value() == 0)
            {
                array_push($negativeConcepts, $concept);
            }
            else
            {
                array_push($positiveConcepts, $concept);
            }
        }

        $image = (new ClarifaiURLImage($imageResponse->getData()->getImage()->getUrl()))
            ->withID($imageResponse->getId())
            ->withPositiveConcepts($positiveConcepts)
            ->withNegativeConcepts($negativeConcepts);

        if (!is_null($imageResponse->getData()->getImage()->getCrop())) {
            $image->withCrop(Crop::deserialize($imageResponse->getData()->getImage()->getCrop()));
        }

        // TODO (Rok) MEDIUM: Implement metadata deserialization.

        if (!is_null($imageResponse->getData()->getGeo())) {
            $image->withGeo(
                GeoPoint::deserialize($imageResponse->getData()->getGeo()->getGeoPoint()));
        }

        if (!is_null($imageResponse->getCreatedAt())) {
            $image->withCreatedAt($imageResponse->getCreatedAt()->toDateTime());
        }

        return $image;
    }
}
