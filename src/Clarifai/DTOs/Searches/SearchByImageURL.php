<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\DTOs\Crop;
use Clarifai\Internal\_And;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_Image;
use Clarifai\Internal\_Input;

class SearchByImageURL extends SearchBy
{

    private $imageURL;
    private $crop;

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
        $image = (new _Image())
            ->setUrl($this->imageURL);
        if (!is_null($this->crop)) {
            $image->setCrop($this->crop->serializeAsArray());
        }
        return ((new _And())
            ->setInput((new _Input())
                ->setData((new _Data())
                    ->setImage($image))));
    }
}
