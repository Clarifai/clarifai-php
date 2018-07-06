<?php

namespace Clarifai\DTOs\Predictions;

use Clarifai\DTOs\Crop;
use Clarifai\Internal\_Region;

class Demographics implements PredictionInterface
{
    /**
     * @inheritdoc
     */
    public function type() { return 'demographics'; }

    private $crop;
    /**
     * @return Crop The crop.
     */
    public function crop() { return $this->crop; }

    private $ageAppearanceConcepts;
    /**
     * @return Concept[] The age-appearance concepts.
     */
    public function ageAppearanceConcepts() { return $this->ageAppearanceConcepts; }

    private $genderAppearanceConcepts;
    /**
     * @return Concept[] The gender-appearance concepts.
     */
    public function genderAppearanceConcepts() { return $this->genderAppearanceConcepts; }

    private $multiculturalAppearanceConcepts;
    /**
     * @return Concept[] The multicultural-appearance concepts.
     */
    public function multiculturalAppearanceConcepts()
    { return $this->multiculturalAppearanceConcepts; }

    /**
     * Ctor.
     * @param Crop $crop The crop.
     * @param Concept[] $ageAppearanceConcepts The age-appearance concepts.
     * @param Concept[] $genderAppearanceConcepts The gender-appearance concepts.
     * @param Concept[] $multiculturalAppearanceConcepts The multicultural-appearance concepts.
     */
    private function __construct($crop, $ageAppearanceConcepts, $genderAppearanceConcepts,
        $multiculturalAppearanceConcepts)
    {
        $this->crop = $crop;
        $this->ageAppearanceConcepts = $ageAppearanceConcepts;
        $this->genderAppearanceConcepts = $genderAppearanceConcepts;
        $this->multiculturalAppearanceConcepts = $multiculturalAppearanceConcepts;
    }

    /**
     * @param _Region $regionResponse
     * @return Demographics
     */
    public static function deserialize($regionResponse)
    {
        $face = $regionResponse->getData()->getFace();

        $ageAppearanceConcepts = [];
        foreach ($face->getAgeAppearance()->getConcepts() as $concept) {
            array_push($ageAppearanceConcepts, Concept::deserialize($concept));
        }
        $genderAppearanceConcepts = [];
        foreach ($face->getGenderAppearance()->getConcepts() as $concept) {
            array_push($genderAppearanceConcepts, Concept::deserialize($concept));
        }
        $multiculturalAppearanceConcepts = [];
        foreach ($face->getMulticulturalAppearance()->getConcepts() as $concept) {
            array_push($multiculturalAppearanceConcepts, Concept::deserialize($concept));
        }
        return new Demographics(
            Crop::deserialize($regionResponse->getRegionInfo()->getBoundingBox()),
            $ageAppearanceConcepts, $genderAppearanceConcepts, $multiculturalAppearanceConcepts);
    }
}
