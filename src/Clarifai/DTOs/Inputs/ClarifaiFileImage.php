<?php

namespace Clarifai\DTOs\Inputs;

use Clarifai\DTOs\Crop;
use Clarifai\DTOs\GeoPoint;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\DTOs\Predictions\Region;
use Clarifai\Helpers\ProtobufHelper;
use Clarifai\Internal\_Concept;
use Clarifai\Internal\_Image;
use Clarifai\Internal\_Input;
use Clarifai\Internal\_Region;

/**
 * A file image.
 */
class ClarifaiFileImage extends ClarifaiInput
{
    private $content;
    /**
     * @return string Image file content encoded as base64.
     */
    public function fileContent() { return $this->content; }

    /**
     * @var Crop The crop.
     */
    private $crop;
    public function crop() { return $this->crop; }
    public function withCrop($val) { $this->crop = $val; return $this; }

    /**
     * Ctor.
     * @param string $fileContent a base64 encoded string of the image
     */
    public function __construct($fileContent)
    {
        parent::__construct(InputType::image(), InputForm::file());
        $this->content = $fileContent;
    }

    /**
     * @return _Input
     */
    public function serialize()
    {
        $image = (new _Image())
            ->setBase64($this->content);
        if (!is_null($this->crop)) {
            $image->setCrop($this->crop->serializeAsArray());
        }
        return parent::serializeInner('image', $image);
    }

    /**
     * @param _Input $imageResponse
     * @return ClarifaiFileImage
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

        $bytes = $data->getImage()->getBase64();
        $image = (new ClarifaiFileImage($bytes))
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

}
