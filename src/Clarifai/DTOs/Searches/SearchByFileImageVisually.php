<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\DTOs\Crop;
use Clarifai\Grpc\Concept;
use Clarifai\Grpc\Data;
use Clarifai\Grpc\Image;
use Clarifai\Grpc\Input;
use Clarifai\Grpc\Output;

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
        $image = (new Image())
            ->setBase64($this->fileContent);
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
