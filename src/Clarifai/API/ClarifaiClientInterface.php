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
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Inputs\ModifyAction;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Models\PublicModels;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\DTOs\Searches\SearchBy;

interface ClarifaiClientInterface
{
    /**
     * @return ClarifaiHttpClientInterface The Clarifai HTTP client.
     */
    public function httpClient();

    /**
     * @return PublicModels All public models.
     */
    public function publicModels();

    /**
     * @param ModelType $type The model type.
     * @param string $modelID The model ID.
     * @return GetModelRequest A new instance.
     */
    public function getModel($type, $modelID);

    /**
     * @return GetModelsRequest A new instance.
     */
    public function getModels();

    /**
     * @param string $modelID The model ID.
     * @return CreateModelRequest A new instance.
     */
    public function createModel($modelID);

    /**
     * @param string $modelID The model ID.
     * @return CreateModelGenericRequest A new instance.
     */
    public function createModelGeneric($modelID);

    /**
     * @param string $modelID THe model ID.
     * @return ModifyModelRequest A new instance.
     */
    public function modifyModel($modelID);

    /**
     * @param string $modelID The model ID.
     * @return DeleteModelRequest A new instance.
     */
    public function deleteModel($modelID);

    /**
     * @param string[]|string $modelIDs The model IDs to delete.
     * @return DeleteModelsRequest A new instance.
     */
    public function deleteModels($modelIDs);

    /**
     * @return DeleteModelsRequest A new instance.
     */
    public function deleteAllModels();

    /**
     * @param ModelType $type The model type.
     * @param string $modelID The model ID.
     * @return TrainModelRequest A new instance.
     */
    public function trainModel($type, $modelID);

    /**
     * @param string $modelID
     * @param string $modelVersionID
     * @return ModelEvaluationRequest A new instance.
     */
    public function modelEvaluation($modelID, $modelVersionID);

    /**
     * @param string $modelID The model ID.
     * @return GetModelVersionsRequest A new instance.
     */
    public function getModelVersions($modelID);

    /**
     * @param string $modelID The model ID.
     * @param string $modelVersionID The model version ID.
     * @return GetModelVersionRequest A new instance.
     */
    public function getModelVersion($modelID, $modelVersionID);

    /**
     * @param string $modelID The model ID.
     * @param string $modelVersionID The model version ID.
     * @return DeleteModelVersionRequest A new instance.
     */
    public function deleteModelVersion($modelID, $modelVersionID);

    /**
     * Adds concepts.
     *
     * @param Concept[]|Concept $concepts The concepts.
     * @return AddConceptsRequest A new instance.
     */
    public function addConcepts($concepts);

    /**
     * Gets a concept.
     *
     * @param string $conceptID
     * @return GetConceptRequest A new instance.
     */
    public function getConcept($conceptID);

    /**
     * Gets concepts.
     *
     * @return GetConceptsRequest A new instance.
     */
    public function getConcepts();

    /**
     * Modifies concepts.
     *
     * @param Concept[]|Concept $concepts The concepts to modify.
     * @return ModifyConceptsRequest A new instance.
     */
    public function modifyConcepts($concepts);

    /**
     * Searches for concepts.
     * @param string $query The query used in search.
     * @return SearchConceptsRequest A new instance.
     */
    public function searchConcepts($query);

    /**
     * Adds inputs.
     *
     * @param $inputs
     * @return AddInputsRequest A new instance.
     */
    public function addInputs($inputs);

    /**
     * Modifies an input.
     *
     * @param string $inputID The input ID.
     * @param ModifyAction $action The modification action.
     * @return ModifyInputRequest A new instance.
     */
    public function modifyInput($inputID, ModifyAction $action);

    /**
     * Gets an input with the ID.
     *
     * @param string $inputID The input ID.
     * @return GetInputRequest A new instance.
     */
    public function getInput($inputID);

    /**
     * Gets all inputs.
     *
     * @return GetInputsRequest A new instance.
     */
    public function getInputs();

    /**
     * Deletes inputs.
     *
     * @param string[]|string $inputIDs The input IDs.
     * @param bool $deleteAll Whether to delete all inputs.
     * @return DeleteInputsRequest A new instance.
     */
    public function deleteInputs($inputIDs, $deleteAll);

    /**
     * If you add inputs in bulk, they will process in the background. With this method you retrieve
     * all inputs' status.
     *
     * @return GetInputsStatusRequest
     */
    public function getInputsStatus();

    /**
     * Returns the model's inputs.
     *
     * @param string $modelID The model ID.
     * @return GetModelInputsRequest A new instance.
     */
    public function getModelInputs($modelID);

    /**
     * Runs a prediction on an input using a certain Model.
     *
     * @param ModelType $modelType The model type.
     * @param string $modelID The model ID.
     * @param ClarifaiInput $input The input.
     * @return PredictRequest A new instance.
     */
    public function predict(ModelType $modelType, $modelID, $input);

    /**
     * Runs a prediction on multiple inputs using a certain Model.
     *
     * @param ModelType $modelType The model type.
     * @param string $modelID The model ID.
     * @param ClarifaiInput[] $inputs The inputs.
     * @return BatchPredictRequest A new instance.
     */
    public function batchPredict(ModelType $modelType, $modelID, $inputs);

    /**
     * Runs a prediction on an input using a certain Workflow.
     *
     * @param string $workflowID The model ID.
     * @param ClarifaiInput $input The input.
     * @return WorkflowPredictRequest A new instance.
     */
    public function workflowPredict($workflowID, $input);


    /**
     * Runs a prediction on inputs using a certain Workflow.
     *
     * @param string $workflowID The model ID.
     * @param ClarifaiInput[] $inputs The inputs.
     * @return WorkflowBatchPredictRequest A new instance.
     */
    public function workflowBatchPredict($workflowID, $inputs);

    /**
     * A request for searching inputs.
     *
     * @param SearchBy[]|SearchBy $searchBys The search clauses.
     * @return SearchInputsRequest A new instance.
     */
    public function searchInputs($searchBys);

    /**
     * Search all the models by name and type of the model.
     *
     * @param string $name The name.
     * @param ModelType|null $modelType The model type.
     * @return SearchModelsRequest A new instance.
     */
    public function searchModels($name, $modelType = null);

    /**
     * Used to send a feedback of prediction success to the model.
     *
     * @param string $modelID
     * @param string $imageURL
     * @param string $inputID
     * @param string $outputID
     * @param string $endUserID
     * @param string $sessionID
     * @return ModelFeedbackRequest
     */
    public function modelFeedback($modelID, $imageURL, $inputID, $outputID, $endUserID, $sessionID);

    /**
     * This request is meant to collect the correctly searched inputs, which is usually done by
     * capturing your end user's clicks on the given search results. Your feedback will help us
     * improve our search algorithm.
     *
     * @param string $inputID The input ID of a correct image (hit).
     * @param string $searchID ID of the search from SearchInputsRequest.
     * @param string $endUserID The ID associated with your end user.
     * @param string $sessionID The ID associated with your user's interface.
     * @return SearchesFeedbackRequest
     */
    public function searchesFeedback($inputID, $searchID, $endUserID, $sessionID);
}
