<?php

namespace Clarifai\Solutions\Moderation\API\Requests\Models;

use Clarifai\API\ClarifaiHttpClientInterface;
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
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     * @param string $modelID The model ID.
     * @param ClarifaiInput $input The input.
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient, $modelID,
        ClarifaiInput $input)
    {
        parent::__construct($httpClient);
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
            return ModerationOutput::deserialize($this->httpClient, $output);
        }
        throw new ClarifaiException('There should be a single output.');
    }
}

