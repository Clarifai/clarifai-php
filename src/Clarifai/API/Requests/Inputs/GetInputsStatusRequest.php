<?php

namespace Clarifai\API\Requests\Inputs;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Inputs\ClarifaiInputsStatus;
use Clarifai\Internal\_GetInputCountRequest;
use Clarifai\Internal\_SingleInputCountResponse;

/**
 * If you add inputs in bulk, they will process in the background. With this method you retrieve
 * all inputs' status.
 */
class GetInputsStatusRequest extends ClarifaiRequest
{
    /**
     * Ctor.
     * @param ClarifaiClientInterface $client The Clarifai client.
     */
    public function __construct(ClarifaiClientInterface $client)
    {
        parent::__construct($client);
    }

    protected function requestMethod()
    {
        return RequestMethod::GET;
    }

    protected function url()
    {
        return '/v2/inputs/status';
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        return $grpcClient->GetInputCount((new _GetInputCountRequest()));
    }

    /**
     * @param _SingleInputCountResponse $response
     * @return ClarifaiInputsStatus
     */
    protected function unmarshaller($response)
    {
        return ClarifaiInputsStatus::deserialize($response->getCounts());
    }
}
