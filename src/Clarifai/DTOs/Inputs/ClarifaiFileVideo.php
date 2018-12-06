<?php

namespace Clarifai\DTOs\Inputs;

use Clarifai\Internal\_Input;
use Clarifai\Internal\_Video;

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
        parent::__construct(InputType::video(), InputForm::file());
        $this->content = $fileContent;
    }

    /**
     * @return _Input
     * @throws \Clarifai\Exceptions\ClarifaiException
     */
    public function serialize()
    {
        $video = (new _Video())
            ->setBase64($this->content);
        return parent::serializeInner('video', $video);
    }
}
