<?php
namespace Clarifai\API\Requests\Models;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\Internal\_DeleteModelVersionRequest;
use Clarifai\Internal\Status\_BaseResponse;

/**
 * Deletes a model version.
 */
class DeleteModelVersionRequest extends ClarifaiRequest
{
    private $modelID;
    private $modelVersionID;

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     * @param string $modelID The model ID.
     * @param string $modelVersionID The model version ID.
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient, $modelID, $modelVersionID)
    {
        parent::__construct($httpClient);
        $this->modelID = $modelID;
        $this->modelVersionID = $modelVersionID;
    }

    protected function requestMethod()
    {
        return RequestMethod::DELETE;
    }

    protected function url()
    {
        return "/v2/models/$this->modelID/versions/$this->modelVersionID";
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        return $grpcClient->DeleteModelVersion(new _DeleteModelVersionRequest());
    }

    /**
     * @param _BaseResponse $response
     * @return void
     */
    protected function unmarshaller($response)
    {
        return;
    }
}
