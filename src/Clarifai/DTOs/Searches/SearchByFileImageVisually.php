<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\DTOs\Crop;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_Image;
use Clarifai\Internal\_Input;
use Clarifai\Internal\_Output;

class SearchByFileImageVisually extends SearchBy
{

    private $fileContent;
    private $crop;

    /**
     * Ctor.
     * @param string $fileContent File content encoded as base64.
     * @param Crop|null $crop
     */
    public function __construct($fileContent, $crop = null)
    {
        $this->fileContent = $fileContent;
        $this->crop = $crop;
    }

    public function serialize()
    {
        $image = (new _Image())
            ->setBase64($this->fileContent);
        if (!is_null($this->crop)) {
            $image->setCrop($this->crop->serializeAsArray());
        }
        return ((new \Clarifai\Internal\_And())
            ->setOutput((new _Output())
                ->setInput((new _Input())
                    ->setData((new _Data())
                        ->setImage($image)))));
    }
}
