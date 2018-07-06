<?php

namespace Clarifai\API\Requests\Models;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Models\ConceptModel;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Internal\_PostModelsRequest;
use Clarifai\Internal\_SingleModelResponse;

/**
 * Creates a new model.
 */
class CreateModelRequest extends ClarifaiRequest
{
    private $modelID;

    private $name;
    /**
     * @param string $val
     * @return CreateModelRequest
     */
    public function withName($val) { $this->name = $val; return $this; }

    private $concepts;
    /**
     * @param Concept[] $val
     * @return CreateModelRequest $this
     */
    public function withConcepts($val) { $this->concepts = $val; return $this; }

    private $areConceptsMutuallyExclusive;
    /**
     * @param bool $val
     * @return CreateModelRequest $this
     */
    public function withAreConceptsMutuallyExclusive($val)
    { $this->areConceptsMutuallyExclusive = $val; return $this; }

    private $isEnvironmentClosed;
    /**
     * @param bool $val
     * @return CreateModelRequest $this
     */
    public function withIsEnvironmentClosed($val)
    { $this->isEnvironmentClosed = $val; return $this; }

    private $language;
    /**
     * @param string $val
     * @return CreateModelRequest $this
     */
    public function withLanguage($val) { $this->language = $val; return $this; }

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

    protected function httpRequestBody(CustomV2Client $client)
    {
        $model = new ConceptModel($this->client, $this->modelID);
        return $client->PostModels(
            (new _PostModelsRequest())->setModel(
                $model->serialize($this->concepts, $this->areConceptsMutuallyExclusive,
                    $this->isEnvironmentClosed, $this->language)));
    }

    /**
     * @param _SingleModelResponse $response
     * @return ConceptModel
     */
    protected function unmarshaller($response)
    {
        return ConceptModel::deserializeInner($this->client, $response->getModel());
    }
}
