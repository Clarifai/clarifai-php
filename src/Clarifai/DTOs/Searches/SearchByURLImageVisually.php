<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\DTOs\Crop;
use Clarifai\Grpc\Concept;
use Clarifai\Grpc\Data;
use Clarifai\Grpc\Image;
use Clarifai\Grpc\Input;
use Clarifai\Grpc\Output;

class SearchByURLImageVisually extends SearchBy
{

    private $imageURL;

    private $crop;
    /**
     * @param Crop $crop The crop.
     * @return $this
     */
    public function withCrop($crop) { $this->crop = $crop; return $this; }

    /**
     * Ctor.
     * @param string $imageURL
     * @param Crop|null $crop
     */
    public function __construct($imageURL, $crop = null)
    {
        $this->imageURL = $imageURL;
        $this->crop = $crop;
    }

    public function serialize()
    {
        $image = (new Image())
            ->setUrl($this->imageURL);
        if (!is_null($this->crop)) {
            $image->setCrop($this->crop->serializeAsArray());
        }
        return ((new \Clarifai\Grpc\PBAnd())
            ->setOutput((new Output())
                ->setInput((new Input())
                    ->setData((new Data())
                        ->setImage($image)))));
    }
}
