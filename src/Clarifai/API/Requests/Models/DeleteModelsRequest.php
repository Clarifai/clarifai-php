<?php

namespace Clarifai\API\Requests\Models;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\Exceptions\ClarifaiException;
use Clarifai\Internal\_DeleteModelsRequest;
use Clarifai\Internal\Status\_BaseResponse;

/**
 * Deletes all custom models.
 */
class DeleteModelsRequest extends ClarifaiRequest
{
    private $modelIDs;
    private $deleteAll;

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     * @param string[]|string $modelIDs The model IDs to delete.
     * @param bool $deleteAll Whether to delete all models.
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient, $modelIDs = [],
        $deleteAll = false)
    {
        parent::__construct($httpClient);
        $this->modelIDs = is_array($modelIDs) ? $modelIDs : [$modelIDs];
        $this->deleteAll = $deleteAll;
        if ((count($this->modelIDs) > 0 && $deleteAll) ||
            ((count($this->modelIDs) == 0) && $deleteAll == false)) {
            throw new ClarifaiException('Set either model IDs or deleteAll');
        }
    }

    protected function requestMethod()
    {
        return RequestMethod::DELETE;
    }

    protected function url()
    {
        return '/v2/models';
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $req = new _DeleteModelsRequest();
        if (count($this->modelIDs) > 0) {
            $req->setIds($this->modelIDs);
        }
        if ($this->deleteAll) {
            $req->setDeleteAll($this->deleteAll);
        }
        return $grpcClient->DeleteModels($req);
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
