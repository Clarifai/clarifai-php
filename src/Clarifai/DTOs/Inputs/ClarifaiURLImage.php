<?php

namespace Clarifai\DTOs\Inputs;

use Clarifai\DTOs\GeoPoint;
use Clarifai\Internal\_Image;
use Clarifai\Internal\_Input;
use Clarifai\DTOs\Crop;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Helpers\ProtobufHelper;

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
     * @return _Input
     */
    public function serialize()
    {
        $image = (new _Image())
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
     * @param _Input $imageResponse
     * @return ClarifaiURLImage
     */
    public static function deserialize($imageResponse)
    {
        $data = $imageResponse->getData();

        $positiveConcepts = [];
        $negativeConcepts = [];
        foreach ($data->getConcepts() as $c)
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

        $image = (new ClarifaiURLImage($data->getImage()->getUrl()))
            ->withID($imageResponse->getId())
            ->withPositiveConcepts($positiveConcepts)
            ->withNegativeConcepts($negativeConcepts);

        $crop = $data->getImage()->getCrop();
        if (!is_null($crop) && $crop->count() > 0) {
            $image->withCrop(Crop::deserialize($crop));
        }

        if (!is_null($data->getMetadata())) {
            $a = new ProtobufHelper();

            $image->withMetadata($a->structToArray($data->getMetadata()));
        }

        if (!is_null($data->getGeo())) {
            $image->withGeo(
                GeoPoint::deserialize($data->getGeo()->getGeoPoint()));
        }

        if (!is_null($imageResponse->getCreatedAt())) {
            $image->withCreatedAt($imageResponse->getCreatedAt()->toDateTime());
        }

        return $image;
    }
}
