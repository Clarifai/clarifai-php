<?php

namespace Clarifai\Solutions\Moderation\API\Requests\Models;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiJsonRequest;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\Exceptions\ClarifaiException;
use Clarifai\Solutions\Moderation\DTOs\ModerationOutput;

class ModerationPredictRequest extends ClarifaiJsonRequest
{
    private $modelID;
    private $input;

    /**
     * Ctor.
     * @param ClarifaiClientInterface $client The Clarifai client.
     * @param string $modelID The model ID.
     * @param ClarifaiInput $input The input.
     */
    public function __construct(ClarifaiClientInterface $client, $modelID,
        ClarifaiInput $input)
    {
        parent::__construct($client);
        $this->modelID = $modelID;
        $this->input = $input;
    }

    protected function requestMethod()
    {
        return RequestMethod::POST;
    }

    protected function url()
    {
        return "v2/models/$this->modelID/outputs";
    }

    public function httpRequestBody() {
        /** @var ClarifaiURLImage $urlImage */
        $urlImage = $this->input;

        return [
            'inputs' => [
                [
                    'data' => [
                        'image' => [
                            'url' => $urlImage->url()
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @param array $jsonObject
     * @return ModerationOutput Our serialized object.
     * @throws ClarifaiException
     */
    public function unmarshaller($jsonObject) {
        $outputs = $jsonObject['outputs'];
        if ($outputs != null && count($outputs) === 1) {
            $output = $outputs[0];
            return ModerationOutput::deserialize($this->client, $output);
        }
        throw new ClarifaiException('There should be a single output.');
    }
}

