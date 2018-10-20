<?php

namespace Clarifai\Solutions\Moderation\API\Requests\Inputs;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiJsonRequest;
use Clarifai\Solutions\Moderation\DTOs\ModerationStatus;

class GetModerationStatusRequest extends ClarifaiJsonRequest
{
    private $inputID;

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     * @param string $inputID The input ID.
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient, $inputID)
    {
        parent::__construct($httpClient);
        $this->inputID = $inputID;
    }

    protected function requestMethod()
    {
        return RequestMethod::GET;
    }

    protected function url()
    {
        return "v2/inputs/$this->inputID/outputs";
    }

    protected function httpRequestBody()
    {
        return null;
    }

    protected function unmarshaller($jsonObject)
    {
        return ModerationStatus::deserializeJson($jsonObject['moderation']['status']);
    }
}
