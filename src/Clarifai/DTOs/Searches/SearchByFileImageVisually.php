<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\Internal\_And;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_Image;
use Clarifai\Internal\_Input;
use Clarifai\Internal\_Output;

class SearchByFileImageVisually extends SearchBy
{

    private $fileContent;

    /**
     * Ctor.
     * @param string $fileContent File content encoded as base64.
     */
    public function __construct($fileContent)
    {
        $this->fileContent = $fileContent;
    }

    public function serialize()
    {
        $image = (new _Image())
            ->setBase64($this->fileContent);
        return ((new _And())
            ->setOutput((new _Output())
                ->setInput((new _Input())
                    ->setData((new _Data())
                        ->setImage($image)))));
    }
}
