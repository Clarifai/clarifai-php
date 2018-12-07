<?php

namespace Clarifai\DTOs\Inputs;

use Clarifai\DTOs\GeoPoint;
use Clarifai\DTOs\Predictions\Region;
use Clarifai\Internal\_Concept;
use Clarifai\Internal\_Image;
use Clarifai\Internal\_Input;
use Clarifai\DTOs\Crop;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Helpers\ProtobufHelper;
use Clarifai\Internal\_Region;

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
        /** @var _Concept $c */
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
            $pbh = new ProtobufHelper();
            $image->withMetadata($pbh->structToArray($data->getMetadata()));
        }

        if (!is_null($data->getGeo())) {
            $image->withGeo(
                GeoPoint::deserialize($data->getGeo()->getGeoPoint()));
        }

        if (!is_null($imageResponse->getCreatedAt())) {
            $image->withCreatedAt($imageResponse->getCreatedAt()->toDateTime());
        }

        if (!is_null($data->getRegions())) {
            $regions = [];
            /** @var _Region $r */
            foreach ($data->getRegions() as $r) {
                array_push($regions, Region::deserialize($r));
            }
            $image->withRegions($regions);
        }

        return $image;
    }

    /**
     * @param array $jsonObject
     * @return ClarifaiInput
     */
    public static function deserializeJson($jsonObject)
    {
        // These are the only currently supported fields in moderation solution.
        return (new ClarifaiURLImage($jsonObject['data']['image']['url']))
            ->withID($jsonObject['id']);
    }
}
