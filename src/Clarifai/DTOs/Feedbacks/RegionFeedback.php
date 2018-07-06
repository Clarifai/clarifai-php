<?php

namespace Clarifai\DTOs\Feedbacks;

use Clarifai\DTOs\Crop;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_Region;
use Clarifai\Internal\_RegionInfo;

class RegionFeedback
{
    /** @var Crop */
    private $crop;
    /**
     * @param Crop $crop The crop.
     * @return $this
     */
    public function withCrop($crop)
    {
        $this->crop = $crop;
        return $this;
    }

    /** @var Feedback */
    private $feedback;
    /**
     * @param Feedback $feedback
     * @return $this
     */
    public function withFeedback($feedback)
    {
        $this->feedback = $feedback;
        return $this;
    }

    private $conceptFeedbacks;
    /**
     * @param ConceptFeedback[] $conceptFeedbacks
     * @return $this
     */
    public function withConceptFeedbacks($conceptFeedbacks)
    {
        $this->conceptFeedbacks = $conceptFeedbacks;
        return $this;
    }

    private $regionID;
    /**
     * @param string $regionID
     * @return $this
     */
    public function withRegionID($regionID)
    {
        $this->regionID = $regionID;
        return $this;
    }

    /** @var FaceFeedback */
    private $faceFeedback;
    /**
     * @param FaceFeedback $faceFeedback
     * @return $this
     */
    public function withFaceFeedback($faceFeedback)
    {
        $this->faceFeedback = $faceFeedback;
        return $this;
    }

    /**
     * Serializes this object to a Protobuf object.
     * @return _Region
     */
    public function serialize()
    {
        $anyData = false;
        $data = new _Data();
        if (!is_null($this->conceptFeedbacks)) {
            $concepts = [];
            /** @var ConceptFeedback $conceptFeedback */
            foreach ($this->conceptFeedbacks as $conceptFeedback)
            {
                array_push($concepts, $conceptFeedback->serialize());
            }
            $data->setConcepts($concepts);
            $anyData = true;
        }

        if (!is_null($this->faceFeedback)) {
            $data->setFace($this->faceFeedback->serialize());
            $anyData = true;
        }

        $regionInfo = new _RegionInfo();
        $anyRegionInfo = false;
        if (!is_null($this->crop)) {
            $regionInfo->setBoundingBox($this->crop->serializeAsObject());
            $anyRegionInfo = true;
        }

        if (!is_null($this->feedback)) {
            $regionInfo->setFeedback($this->feedback->value());
            $anyRegionInfo = true;
        }

        $region = new _Region();
        if (!is_null($this->regionID)) {
            $region->setId($this->regionID);
        }

        if ($anyData) {
            $region->setData($data);
        }

        if ($anyRegionInfo) {
            $region->setRegionInfo($regionInfo);
        }

        return $region;
    }
}
