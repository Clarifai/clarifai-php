<?php

namespace Clarifai\DTOs\Inputs;

use Clarifai\Grpc\Video;
use Clarifai\DTOs\Crop;

/**
 * A file video.
 */
class ClarifaiFileVideo extends ClarifaiInput
{
    private $content;
    /**
     * @return string Video file content encoded as base64.
     */
    public function fileContent() { return $this->content; }

    /**
     * Ctor.
     * @param string $fileContent A base64 encoded string of the video.
     */
    public function __construct($fileContent)
    {
        parent::__construct(InputType::image(), InputForm::file());
        $this->content = $fileContent;
    }

    /**
     * @return \Clarifai\Grpc\Input
     */
    public function serialize()
    {
        $video = (new \Clarifai\Grpc\Video())
            ->setBase64($this->content);
        return parent::serializeInner('video', $video);
    }
}
