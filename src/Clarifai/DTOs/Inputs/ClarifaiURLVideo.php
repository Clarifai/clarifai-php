<?php

namespace Clarifai\DTOs\Inputs;

use Clarifai\DTOs\GeoPoint;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Grpc\Video;

/**
 * A video at a certain URL. (WIP)
 */
class ClarifaiURLVideo extends ClarifaiInput
{
    private $url;
    public function url() { return $this->url; }

    /**
     * Ctor.
     * @param string $url the URL of the video
     */
    public function __construct($url)
    {
        parent::__construct(InputType::video(), InputForm::file());
        $this->url = $url;
    }

    public function serialize()
    {
        $video = (new Video())
            ->setUrl($this->url);

        return parent::serializeInner('video', $video);
    }

    /**
     * @param \Clarifai\Grpc\Input $videoResponse
     *
     * @return ClarifaiURLVideo
     */
    public static function deserialize($videoResponse)
    {
        $positiveConcepts = [];
        $negativeConcepts = [];
        foreach ($videoResponse->getData()->getConcepts() as $c)
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

        $video = (new ClarifaiURLVideo($videoResponse->getData()->getImage()->getUrl()))
            ->withID($videoResponse->getId())
            ->withPositiveConcepts($positiveConcepts)
            ->withNegativeConcepts($negativeConcepts);

        // TODO (Rok) MEDIUM: Implement metadata deserialization.

        if (!is_null($videoResponse->getData()->getGeo())) {
            $video->withGeo(
                GeoPoint::deserialize($videoResponse->getData()->getGeo()->getGeoPoint()));
        }

        if (!is_null($videoResponse->getCreatedAt())) {
            $video->withCreatedAt($videoResponse->getCreatedAt()->toDateTime());
        }

        return $video;
    }
}
