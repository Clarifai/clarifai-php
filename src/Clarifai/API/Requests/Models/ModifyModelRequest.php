<?php

namespace Clarifai\API\Requests\Models;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Inputs\ModifyAction;
use Clarifai\DTOs\Models\ConceptModel;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Internal\_MultiModelResponse;
use Clarifai\Internal\_PatchModelsRequest;

/**
 * Modifies a model.
 */
class ModifyModelRequest extends ClarifaiRequest
{
    private $modelID;

    private $modifyAction;

    /**
     * The way in the modification will occur.
     * @param ModifyAction $val The modification action.
     * @return ModifyModelRequest
     */
    public function withModifyAction($val) { $this->modifyAction = $val; return $this; }

    private $name;
    /**
     * @param string $val
     * @return ModifyModelRequest
     */
    public function withName($val) { $this->name = $val; return $this; }

    private $concepts;
    /**
     * @param Concept[] $val
     * @return ModifyModelRequest $this
     */
    public function withConcepts($val) { $this->concepts = $val; return $this; }

    private $areConceptsMutuallyExclusive;
    /**
     * @param bool $val
     * @return ModifyModelRequest $this
     */
    public function withAreConceptsMutuallyExclusive($val)
    { $this->areConceptsMutuallyExclusive = $val; return $this; }

    private $isEnvironmentClosed;
    /**
     * @param bool $val
     * @return ModifyModelRequest $this
     */
    public function withIsEnvironmentClosed($val)
    { $this->isEnvironmentClosed = $val; return $this; }

    private $language;
    /**
     * @param string $val
     * @return ModifyModelRequest $this
     */
    public function withLanguage($val) { $this->language = $val; return $this; }

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
        return RequestMethod::PATCH;
    }

    protected function url()
    {
        return '/v2/models';
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $model = new ConceptModel($this->client, $this->modelID);
        if (!is_null($this->name)) {
            $model = $model->withName($this->name);
        }
        $modifyAction = !is_null($this->modifyAction) ? $this->modifyAction : ModifyAction::merge();
        return $grpcClient->PatchModels((new _PatchModelsRequest())
            ->setModels([$model->serialize($this->concepts, $this->areConceptsMutuallyExclusive,
                    $this->isEnvironmentClosed, $this->language)])
            ->setAction($modifyAction->serialize()));
    }

    /**
     * @param _MultiModelResponse $response
     * @return \Clarifai\DTOs\Models\Model
     * @throws \Clarifai\Exceptions\ClarifaiException
     */
    protected function unmarshaller($response)
    {
        return ConceptModel::deserialize($this->client, ModelType::concept(),
            $response->getModels()->offsetGet(0));
    }
}
