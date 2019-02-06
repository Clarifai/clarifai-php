<?php

namespace Clarifai\API\Requests\Inputs;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\Exceptions\ClarifaiException;
use Clarifai\Internal\_DeleteInputsRequest;
use Clarifai\Internal\Status\_BaseResponse;

class DeleteInputsRequest extends ClarifaiRequest
{

    private $inputIDs;
    private $deleteAll;

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     * @param string[]|string $inputIDs the input IDs
     * @param bool $deleteAll Whether to delete all inputs.
     * @throws ClarifaiException Throws when parameters are invalid.
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient, $inputIDs = [],
        $deleteAll = false)
    {
        parent::__construct($httpClient);
        $this->inputIDs = is_array($inputIDs) ? $inputIDs : [$inputIDs];
        $this->deleteAll = $deleteAll;
        if ((count($this->inputIDs) > 0 && $deleteAll) ||
            ((count($this->inputIDs) == 0) && $deleteAll == false)) {
            throw new ClarifaiException('Set either input IDs or deleteAll');
        }
    }

    protected function requestMethod()
    {
        return RequestMethod::DELETE;
    }

    protected function url()
    {
        return '/v2/inputs';
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $req = new _DeleteInputsRequest();
        if (count($this->inputIDs) > 0) {
            $req->setIds($this->inputIDs);
        }
        if ($this->deleteAll) {
            $req->setDeleteAll($this->deleteAll);
        }
        return $grpcClient->DeleteInputs($req);
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
