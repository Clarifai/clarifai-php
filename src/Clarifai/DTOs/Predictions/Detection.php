<?php

namespace Clarifai\DTOs\Predictions;

use Clarifai\DTOs\Crop;
use Clarifai\Internal\_Region;

class Detection implements PredictionInterface
{
    /**
     * @inheritdoc
     */
    public function type() { return 'detect-concept'; }

    private $crop;
    /**
     * @return Crop The crop in which the detection is located.
     */
    public function crop() { return $this->crop; }

    private $concepts;
    /**
     * @return Concept[] The concepts.
     */
    public function concepts() { return $this->concepts; }

    private $ageAppearanceConcepts;
    /**
     * @return Concept[] The age appearance concepts.
     */
    public function ageAppearanceConcepts() { return $this->ageAppearanceConcepts; }

    private $genderAppearanceConcepts;
    /**
     * @return Concept[] The gender appearance concepts.
     */
    public function genderAppearanceConcepts() { return $this->genderAppearanceConcepts; }

    private $multiculturalAppearanceConcepts;
    /**
     * @return Concept[] The multicultural appearance concepts.
     */
    public function multiculturalAppearanceConcepts() { return $this->multiculturalAppearanceConcepts; }

    /**
     * Ctor.
     * @param Crop $crop The crop.
     * @param Concept[] $concepts The concepts.
     * @param Concept[] $ageAppearanceConcepts The face's age appearance concepts.
     * @param Concept[] $genderAppearanceConcepts The face's gender appearance concepts.
     * @param Concept[] $multiculturalAppearanceConcepts The face's multicultural appearance concepts.
     */
    private function __construct(
        $crop,
        $concepts,
        $ageAppearanceConcepts,
        $genderAppearanceConcepts,
        $multiculturalAppearanceConcepts
    )
    {
        $this->crop = $crop;
        $this->concepts = $concepts;
        $this->ageAppearanceConcepts = $ageAppearanceConcepts;
        $this->genderAppearanceConcepts = $genderAppearanceConcepts;
        $this->multiculturalAppearanceConcepts = $multiculturalAppearanceConcepts;
    }

    /**
     * @param _Region $regionResponse
     * @return Detection
     */
    public static function deserialize($regionResponse)
    {
        $concepts = [];
        $ageConcepts = [];
        $genderConcepts = [];
        $multiculturalConcepts = [];
        if (!is_null($regionResponse->getData())) {
            foreach ($regionResponse->getData()->getConcepts() as $concept) {
                array_push($concepts, Concept::deserialize($concept));
            }

            if (!is_null($regionResponse->getData()->getFace())) {
                foreach ($regionResponse->getData()->getFace()->getAgeAppearance()->getConcepts()
                         as $ageConcept) {
                    array_push($ageConcepts, Concept::deserialize($ageConcept));
                }
                foreach ($regionResponse->getData()->getFace()->getGenderAppearance()->getConcepts()
                         as $genderConcept) {
                    array_push($genderConcepts, Concept::deserialize($genderConcept));
                }
                foreach ($regionResponse->getData()->getFace()->getMulticulturalAppearance()->getConcepts()
                         as $multiculturalConcept) {
                    array_push($multiculturalConcepts, Concept::deserialize($multiculturalConcept));
                }
            }
        }

        return new Detection(Crop::deserialize($regionResponse->getRegionInfo()->getBoundingBox()),
            $concepts, $ageConcepts, $genderConcepts, $multiculturalConcepts);
    }
}
