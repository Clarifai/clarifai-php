<?php

namespace Clarifai\Solutions\Moderation;

use Clarifai\API\ClarifaiClient;
use Clarifai\API\ClarifaiHttpClient;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\Solutions\Moderation\API\Requests\Inputs\GetModerationStatusRequest;
use Clarifai\Solutions\Moderation\API\Requests\Models\ModerationPredictRequest;

class Moderation
{
    private $client;

    /**
     * Ctor.
     * @param string $apiKey The Clarifai API key.
     */
    public function __construct($apiKey)
    {
        $this->client = new ClarifaiClient(
            null, new ClarifaiHttpClient($apiKey, 'https://api.clarifai-moderation.com'));
    }

    /**
     * Runs a moderation prediction on an input.
     *
     * @param string $modelID The model ID.
     * @param ClarifaiInput $input The input.
     * @return ModerationPredictRequest A new instance.
     */
    public function predict($modelID, $input)
    {
        return new ModerationPredictRequest($this->client, $modelID, $input);
    }

    /**
     * @param string $inputID The input ID.
     * @return GetModerationStatusRequest A new instance.
     */
    public function getModerationStatus($inputID)
    {
        return new GetModerationStatusRequest($this->client, $inputID);
    }
}
