<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\Internal\_And;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_Image;
use Clarifai\Internal\_Input;
use Clarifai\Internal\_Output;

class SearchByURLImageVisually extends SearchBy
{

    private $imageURL;

    /**
     * Ctor.
     * @param string $imageURL
     */
    public function __construct($imageURL)
    {
        $this->imageURL = $imageURL;
    }

    public function serialize()
    {
        $image = (new _Image())
            ->setUrl($this->imageURL);
        return ((new _And())
            ->setOutput((new _Output())
                ->setInput((new _Input())
                    ->setData((new _Data())
                        ->setImage($image)))));
    }
}
