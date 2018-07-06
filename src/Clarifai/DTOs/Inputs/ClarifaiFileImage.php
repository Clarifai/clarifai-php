<?php

namespace Clarifai\DTOs\Inputs;

use Clarifai\DTOs\Crop;
use Clarifai\Internal\_Image;
use Clarifai\Internal\_Input;

/**
 * A file image.
 */
class ClarifaiFileImage extends ClarifaiInput
{
    private $content;
    /**
     * @return string Image file content encoded as base64.
     */
    public function fileContent() { return $this->content; }

    /**
     * @var Crop The crop.
     */
    private $crop;
    public function crop() { return $this->crop; }
    public function withCrop($val) { $this->crop = $val; return $this; }

    /**
     * Ctor.
     * @param string $fileContent a base64 encoded string of the image
     */
    public function __construct($fileContent)
    {
        parent::__construct(InputType::image(), InputForm::file());
        $this->content = $fileContent;
    }

    /**
     * @return _Input
     */
    public function serialize()
    {
        $image = (new _Image())
            ->setBase64($this->content);
        if (!is_null($this->crop)) {
            $image->setCrop($this->crop->serializeAsArray());
        }
        return parent::serializeInner('image', $image);
    }
}
