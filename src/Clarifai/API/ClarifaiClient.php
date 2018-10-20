<?php

namespace Clarifai\API;

use Clarifai\API\Requests\Concepts\AddConceptsRequest;
use Clarifai\API\Requests\Concepts\GetConceptRequest;
use Clarifai\API\Requests\Concepts\GetConceptsRequest;
use Clarifai\API\Requests\Concepts\ModifyConceptsRequest;
use Clarifai\API\Requests\Concepts\SearchConceptsRequest;
use Clarifai\API\Requests\Feedbacks\ModelFeedbackRequest;
use Clarifai\API\Requests\Feedbacks\SearchesFeedbackRequest;
use Clarifai\API\Requests\Inputs\AddInputsRequest;
use Clarifai\API\Requests\Inputs\DeleteInputsRequest;
use Clarifai\API\Requests\Inputs\GetInputRequest;
use Clarifai\API\Requests\Inputs\GetInputsRequest;
use Clarifai\API\Requests\Inputs\GetInputsStatusRequest;
use Clarifai\API\Requests\Inputs\ModifyInputRequest;
use Clarifai\API\Requests\Inputs\SearchInputsRequest;
use Clarifai\API\Requests\Models\BatchPredictRequest;
use Clarifai\API\Requests\Models\CreateModelGenericRequest;
use Clarifai\API\Requests\Models\CreateModelRequest;
use Clarifai\API\Requests\Models\DeleteModelsRequest;
use Clarifai\API\Requests\Models\DeleteModelRequest;
use Clarifai\API\Requests\Models\DeleteModelVersionRequest;
use Clarifai\API\Requests\Models\GetModelInputsRequest;
use Clarifai\API\Requests\Models\GetModelRequest;
use Clarifai\API\Requests\Models\GetModelsRequest;
use Clarifai\API\Requests\Models\GetModelVersionRequest;
use Clarifai\API\Requests\Models\GetModelVersionsRequest;
use Clarifai\API\Requests\Models\ModelEvaluationRequest;
use Clarifai\API\Requests\Models\ModifyModelRequest;
use Clarifai\API\Requests\Models\PredictRequest;
use Clarifai\API\Requests\Models\SearchModelsRequest;
use Clarifai\API\Requests\Models\TrainModelRequest;
use Clarifai\API\Requests\Models\WorkflowBatchPredictRequest;
use Clarifai\API\Requests\Models\WorkflowPredictRequest;
use Clarifai\DTOs\Inputs\ModifyAction;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Models\PublicModels;
use Clarifai\Solutions\Solutions;

class ClarifaiClient implements ClarifaiClientInterface
{
    private $httpClient;
    private $apiKey;
    private $publicModels;
    private $solutions;

    /**
     * Ctor.
     * @param string $apiKey the Clarifai API key
     * @param null|ClarifaiHttpClientInterface $customHttpClient a custom HTTP client
     */
    public function __construct($apiKey = null, $customHttpClient = null)
    {
        if ($apiKey == null) {
            $apiKey = getenv('CLARIFAI_API_KEY');
        }

        if ($customHttpClient == null) {
            $this->httpClient = new ClarifaiHttpClient($apiKey);
        } else {
            $this->httpClient = $customHttpClient;
        }
        $this->apiKey = $apiKey;

        $this->publicModels = new PublicModels($this->httpClient);
        $this->solutions = new Solutions($this->apiKey);
    }

    /**
     * @inheritdoc
     */
    public function httpClient()
    {
        return $this->httpClient;
    }

    /**
     * @inheritdoc
     */
    public function publicModels()
    {
        return $this->publicModels;
    }

    /**
     * @inheritdoc
     */
    public function solutions()
    {
        return $this->solutions;
    }

    /**
     * @inheritdoc
     */
    public function getModel($type, $modelID)
    {
        return new GetModelRequest($this->httpClient, $type, $modelID);
    }

    /**
     * @inheritdoc
     */
    public function getModels()
    {
        return new GetModelsRequest($this->httpClient);
    }

    /**
     * @inheritdoc
     */
    public function createModel($modelID)
    {
        return new CreateModelRequest($this->httpClient, $modelID);
    }

    /**
     * @inheritdoc
     */
    public function createModelGeneric($modelID)
    {
        return new CreateModelGenericRequest($this->httpClient, $modelID);
    }

    /**
     * @inheritdoc
     */
    public function modifyModel($modelID)
    {
        return new ModifyModelRequest($this->httpClient, $modelID);
    }

    /**
     * @inheritdoc
     */
    public function deleteModel($modelID)
    {
        return new DeleteModelRequest($this->httpClient, $modelID);
    }

    /**
     * @inheritdoc
     * @throws \Clarifai\Exceptions\ClarifaiException
     */
    public function deleteModels($modelIDs)
    {
        return new DeleteModelsRequest($this->httpClient, $modelIDs, false);
    }

    /**
     * @inheritdoc
     * @throws \Clarifai\Exceptions\ClarifaiException
     */
    public function deleteAllModels()
    {
        return new DeleteModelsRequest($this->httpClient, [], true);
    }

    /**
     * @inheritdoc
     */
    public function trainModel($type, $modelID)
    {
        return new TrainModelRequest($this->httpClient, $type, $modelID);
    }

    /**
     * @inheritdoc
     */
    public function modelEvaluation($modelID, $modelVersionID)
    {
        return new ModelEvaluationRequest($this->httpClient, $modelID, $modelVersionID);
    }

    /**
     * @inheritdoc
     */
    public function getModelVersions($modelID)
    {
        return new GetModelVersionsRequest($this->httpClient, $modelID);
    }

    /**
     * @inheritdoc
     */
    public function getModelVersion($modelID, $modelVersionID)
    {
        return new GetModelVersionRequest($this->httpClient, $modelID, $modelVersionID);
    }

    /**
     * @inheritdoc
     */
    public function deleteModelVersion($modelID, $modelVersionID)
    {
        return new DeleteModelVersionRequest($this->httpClient, $modelID, $modelVersionID);
    }

    /**
     * @inheritdoc
     */
    public function addConcepts($concepts)
    {
        return new AddConceptsRequest($this->httpClient, $concepts);
    }

    /**
     * @inheritdoc
     */
    public function getConcept($conceptID)
    {
        return new GetConceptRequest($this->httpClient, $conceptID);
    }

    /**
     * @inheritdoc
     */
    public function getConcepts()
    {
        return new GetConceptsRequest($this->httpClient);
    }

    /**
     * @inheritdoc
     */
    public function modifyConcepts($concepts)
    {
        return new ModifyConceptsRequest($this->httpClient, $concepts);
    }

    /**
     * @inheritdoc
     */
    public function searchConcepts($query)
    {
        return new SearchConceptsRequest($this->httpClient, $query);
    }

    /**
     * @inheritdoc
     */
    public function addInputs($inputs)
    {
        return new AddInputsRequest($this->httpClient, $inputs);
    }

    /**
     * @inheritdoc
     */
    public function modifyInput($inputID, ModifyAction $action)
    {
        return new ModifyInputRequest($this->httpClient, $inputID, $action);
    }

    /**
     * @inheritdoc
     */
    public function getInput($inputID)
    {
        return new GetInputRequest($this->httpClient, $inputID);
    }

    /**
     * @inheritdoc
     */
    public function getInputs()
    {
        return new GetInputsRequest($this->httpClient);
    }

    /**
     * @inheritdoc
     */
    public function deleteInputs($inputIDs = [], $deleteAll = false)
    {
        return new DeleteInputsRequest($this->httpClient, $inputIDs, $deleteAll);
    }

    /**
     * @inheritdoc
     */
    public function getInputsStatus()
    {
        return new GetInputsStatusRequest($this->httpClient);
    }

    /**
     * @inheritdoc
     */
    public function getModelInputs($modelID)
    {
        return new GetModelInputsRequest($this->httpClient, $modelID);
    }

    /**
     * @inheritdoc
     */
    public function predict(ModelType $modelType, $modelID, $input)
    {
        return new PredictRequest($this->httpClient, $modelType, $modelID, $input);
    }

    /**
     * @inheritdoc
     */
    public function batchPredict(ModelType $modelType, $modelID, $inputs)
    {
        return new BatchPredictRequest($this->httpClient, $modelType, $modelID, $inputs);
    }

    /**
     * @inheritdoc
     */
    public function workflowPredict($workflowID, $input)
    {
        return new WorkflowPredictRequest($this->httpClient, $workflowID, $input);
    }

    /**
     * @inheritdoc
     */
    public function workflowBatchPredict($workflowID, $inputs)
    {
        return new WorkflowBatchPredictRequest($this->httpClient, $workflowID, $inputs);
    }

    /**
     * @inheritdoc
     */
    public function searchInputs($searchBys)
    {
        return new SearchInputsRequest($this->httpClient, $searchBys);
    }

    /**
     * @inheritdoc
     */
    public function searchModels($name, $modelType = null)
    {
        return new SearchModelsRequest($this->httpClient, $name, $modelType);
    }

    /**
     * @inheritdoc
     */
    public function modelFeedback($modelID, $imageURL, $inputID, $outputID, $endUserID, $sessionID)
    {
        return new ModelFeedbackRequest($this->httpClient, $modelID, $imageURL, $inputID, $outputID,
            $endUserID, $sessionID);
    }

    /**
     * @inheritdoc
     */
    public function searchesFeedback($inputID, $searchID, $endUserID, $sessionID)
    {
        return new SearchesFeedbackRequest($this->httpClient, $inputID, $searchID, $endUserID,
            $sessionID);
    }
}
