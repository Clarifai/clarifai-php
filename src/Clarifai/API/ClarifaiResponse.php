<?php
namespace Clarifai\API;

use Clarifai\DTOs\ClarifaiStatus;
use Clarifai\DTOs\StatusType;

class ClarifaiResponse
{
    private $status;
    public function status() { return $this->status; }

    private $rawBody;
    public function rawBody() { return $this->rawBody; }

    private $deserialized;
    public function get() { return $this->deserialized; }

    public function __construct(ClarifaiStatus $status, $rawBody, $deserialized)
    {
        $this->status = $status;
        $this->rawBody = $rawBody;
        $this->deserialized = $deserialized;
    }

    public function isSuccessful()
    {
        return StatusType::successful() == $this->status()->type();
    }
}
