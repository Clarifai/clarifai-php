<?php

namespace Clarifai\API\Requests\Models;

use Clarifai\DTOs\Models\Model;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Models\OutputInfos\OutputInfoInterface;
use Clarifai\Exceptions\ClarifaiException;
use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\Internal\_Model;
use Clarifai\Internal\_PostModelsRequest;
use Clarifai\Internal\_SingleModelResponse;

/**
 * Creates a new model.
 */
class CreateModelGenericRequest extends ClarifaiRequest
{
    private $modelID;

    private $name;
    /**
     * @param string $val
     * @return CreateModelGenericRequest
     */
    public function withName($val) { $this->name = $val; return $this; }

    /** @var OutputInfoInterface */
    private $outputInfo;
    /**
     * @param OutputInfoInterface $val
     * @return CreateModelGenericRequest $this
     */
    public function withOutputInfo($val) { $this->outputInfo = $val; return $this; }

    /**
     * Ctor.
     * @param ClarifaiClientInterface $client the Clarifai client
     * @param string $modelID the model ID
     */
    public function __construct(ClarifaiClientInterface $client, $modelID)
    {
        parent::__construct($client);
        $this->modelID = $modelID;
    }

    protected function requestMethod()
    {
        return RequestMethod::POST;
    }

    protected function url()
    {
        return '/v2/models';
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $model = (new _Model())
            ->setId($this->modelID);
        if (!is_null($this->name)) {
            $model->setName($this->name);
        }
        if (!is_null($this->outputInfo)) {
            $model->setOutputInfo($this->outputInfo->serialize());
        }
        return $grpcClient->PostModels((new _PostModelsRequest())
            ->setModel($model));
    }

    /**
     * @param _SingleModelResponse $response
     * @return Model
     * @throws ClarifaiException
     */
    protected function unmarshaller($response)
    {
        $model = $response->getModel();
        $typeExt = $model->getOutputInfo()->getTypeExt();

        $modelType = ModelType::determineModelType($typeExt);
        if (is_null($modelType)) {
            throw new ClarifaiException("Unknown model type '$typeExt'. Skipping.");
        }

        return Model::deserialize($this->client, $modelType, $model);
    }
}
