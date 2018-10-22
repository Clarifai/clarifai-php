<?php
namespace Clarifai\DTOs\Predictions;

use Clarifai\Helpers\DateTimeHelper;
use Clarifai\Internal\_Concept;

/**
 * Represents a string associated with an input (image or video). Also called a label or a tag.
 * @package Clarifai\DTOs\Predictions
 */
class Concept implements PredictionInterface
{
    /**
     * @inheritdoc
     */
    public function type() { return 'concept'; }

    private $id;
    public function id() { return $this->id; }

    private $name;
    public function name() { return $this->name; }
    public function withName($val) { $this->name = $val; return $this; }

    private $language;
    public function language() { return $this->language; }
    public function withLanguage($val) { $this->language = $val; return $this; }

    private $value;
    public function value() { return $this->value; }
    private function withValue($val) { $this->value = $val; return $this; }

    private $createdAt;
    public function createdAt() { return $this->createdAt; }
    private function withCreatedAt($val) { $this->createdAt = $val; return $this; }

    private $appID;
    public function appID() { return $this->appID; }
    private function withAppID($val) { $this->appID = $val; return $this; }

    /**
     * Ctor.
     * @param string $id the Concept ID
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @param bool|null $value the value
     * @return _Concept a serialized object
     */
    public function serialize($value = null)
    {
        $concept = (new _Concept())
            ->setId($this->id);
        if (!is_null($this->name)) {
            $concept->setName($this->name);
        }
        if (!is_null($this->language)) {
            $concept->setLanguage($this->language);
        }

        if (!is_null($value)) {
            // Using -1.0 instead of 0.0 is a hack to avoid Protobuf's skipping of fields with
            // default values. We later convert this -1.0 to 0.0.
            $concept->setValue($value ? 1.0 : -1.0);
        }

        return $concept;
    }

    /**
     * @param _Concept $conceptResponse
     * @return Concept
     */
    public static function deserialize($conceptResponse)
    {
        $createdAt = null;
        if ($conceptResponse->getCreatedAt() != null) {
            $createdAt = $conceptResponse->getCreatedAt()->toDateTime();
        }
        return (new Concept($conceptResponse->getId()))
            ->withName($conceptResponse->getName())
            ->withLanguage($conceptResponse->getLanguage())
            ->withValue($conceptResponse->getValue())
            ->withCreatedAt($createdAt)
            ->withAppID($conceptResponse->getAppId());
    }

    /**
     * @param array $jsonObject
     * @return Concept
     */
    public static function deserializeJson($jsonObject)
    {
        $createdAt = null;
        if (array_key_exists('created_at', $jsonObject)) {
            $createdAt = DateTimeHelper::parseDateTime($jsonObject['created_at']);
        }
        return (new Concept($jsonObject['id']))
            ->withName($jsonObject['name'])
            ->withLanguage($jsonObject['language'])
            ->withValue($jsonObject['value'])
            ->withCreatedAt($createdAt)
            ->withAppID($jsonObject['app_id']);
    }

    public function __toString()
    {
        return "[Concept: (id: $this->id, name: $this->name, value: $this->value)]";
    }
}
