<?php

namespace Clarifai\API\Requests\Models;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\Internal\_DeleteModelRequest;
use Clarifai\Internal\Status\_BaseResponse;

/**
 * Deletes a model.
 */
class DeleteModelRequest extends ClarifaiRequest
{
    private $modelID;

    /**
     * Ctor.
     * @param ClarifaiClientInterface $client The Clarifai client.
     * @param string $modelID The model ID.
     */
    public function __construct(ClarifaiClientInterface $client, $modelID)
    {
        parent::__construct($client);
        $this->modelID = $modelID;
    }

    protected function requestMethod()
    {
        return RequestMethod::DELETE;
    }

    protected function url()
    {
        return '/v2/models/' . $this->modelID;
    }

    protected function httpRequestBody(CustomV2Client $client)
    {
        return $client->DeleteModel(new _DeleteModelRequest());
    }

    /**
     * @param _BaseResponse $response The response.
     * @return void
     */
    protected function unmarshaller($response)
    {
        return;
    }
}
