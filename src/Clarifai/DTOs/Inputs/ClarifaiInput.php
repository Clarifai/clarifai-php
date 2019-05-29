<?php

namespace Clarifai\DTOs\Inputs;

use Clarifai\DTOs\GeoPoint;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\DTOs\Predictions\Region;
use Clarifai\Exceptions\ClarifaiException;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_Geo;
use Clarifai\Helpers\ProtobufHelper;
use Clarifai\Internal\_Image;
use Clarifai\Internal\_Input;
use Clarifai\Internal\_Video;

abstract class ClarifaiInput
{
    private $type;
    public function type() { return $this->type; }

    private $form;
    public function form() { return $this->form; }

    private $id;
    public function id() { return $this->id; }
    public function withID($val) { $this->id = $val; return $this; }

    private $positiveConcepts;
    /**
     * @return Concept[]
     */
    public function positiveConcepts() { return $this->positiveConcepts; }
    /**
     * @param Concept[] $val
     * @return $this
     */
    public function withPositiveConcepts($val) { $this->positiveConcepts = $val; return $this; }

    private $negativeConcepts;
    /**
     * @return Concept[]
     */
    public function negativeConcepts() { return $this->negativeConcepts; }
    /**
     * @param Concept[] $val
     * @return $this
     */
    public function withNegativeConcepts($val) { $this->negativeConcepts = $val; return $this; }

    private $metadata;
    /**
     * @return array
     */
    public function metadata() { return $this->metadata; }
    /**
     * @param array $val
     * @return $this
     */
    public function withMetadata($val) { $this->metadata = $val; return $this; }

    private $createdAt;

    /**
     * @return \DateTime
     */
    public function createdAt() { return $this->createdAt; }
    /**
     * @param \DateTime $val
     * @return $this
     */
    public function withCreatedAt($val) { $this->createdAt = $val; return $this; }

    /** @var GeoPoint */
    private $geo;
    /**
     * @return GeoPoint
     */
    public function geo() { return $this->geo; }
    /**
     * @param GeoPoint $val
     * @return $this
     */
    public function withGeo($val) { $this->geo = $val; return $this; }

    private $regions;
    /**
     * @return Region[]
     */
    public function regions() { return $this->regions; }
    public function withRegions($val) { $this->regions = $val; return $this; }


    public function __construct($type, $form)
    {
        $this->type = $type;
        $this->form = $form;
    }

    /**
     * @return _Input
     */
    public abstract function serialize();

    /**
     * @param string $inputType
     * @param _Image|_Video $imageOrVideo
     * @return _Input
     */
    protected function serializeInner($inputType, $imageOrVideo)
    {
        $data = new _Data();
        if ($inputType == 'image') {
            $data->setImage($imageOrVideo);
        } else if ($inputType == 'video') {
            $data->setVideo($imageOrVideo);
        } else {
            throw new ClarifaiException("Unknown inputType $inputType.");
        }
        $concepts = [];
        if ($this->positiveConcepts != null) {
            foreach ($this->positiveConcepts() as $concept) {
                array_push($concepts, $concept->serialize(true));
            }
        }
        if ($this->negativeConcepts != null) {
            foreach ($this->negativeConcepts() as $concept) {
                array_push($concepts, $concept->serialize(false));
            }
        }
        if (count($concepts) > 0) {
            $data->setConcepts($concepts);
        }

        if (!is_null($this->metadata)) {
            $pbh = new ProtobufHelper();
            $data->setMetadata($pbh->arrayToStruct($this->metadata));
        }

        if (!is_null($this->geo)) {
            $data->setGeo((new _Geo())
                ->setGeoPoint($this->geo->serialize()));
        }
        return (new _Input())
            ->setId($this->id)
            ->setData($data);
    }

    /**
     * @param _Input $inputResponse
     * @return ClarifaiInput Serialized input.
     */
    public static function deserialize($inputResponse)
    {
        if (!is_null($inputResponse->getData()->getImage())) {
            if ($inputResponse->getData()->getImage()->getUrl() != '') {
                return ClarifaiURLImage::deserialize($inputResponse);
            } else {
                return ClarifaiFileImage::deserialize($inputResponse);
            }
        } else if(!is_null($inputResponse->getData()->getVideo())) {
            if ($inputResponse->getData()->getVideo()->getUrl() != '') {
                return ClarifaiURLVideo::deserialize($inputResponse);
            } else {
                return ClarifaiFileVideo::deserialize($inputResponse);
            }
        } else {
            throw new ClarifaiException("Unknown ClarifaiInput type. Neither image or video.");
        }
    }

    /**
     * @param array $jsonObject
     * @return ClarifaiInput Serialized input.
     */
    public static function deserializeJson($jsonObject)
    {
        // Currently, the moderation solution, which calls this function, only supports an URL
        // image, so it's the only one we need to deserialize.
        return ClarifaiURLImage::deserializeJson($jsonObject);
    }
}
