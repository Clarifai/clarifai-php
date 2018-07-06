<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Clarifai\Internal;

/**
 */
class V2Client extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \Clarifai\Internal\_TestMessage $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Echo(\Clarifai\Internal\_TestMessage $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/Echo',
        $argument,
        ['\Clarifai\Internal\_TestMessage', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetConceptCountsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetConceptCounts(\Clarifai\Internal\_GetConceptCountsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetConceptCounts',
        $argument,
        ['\Clarifai\Internal\_MultiConceptCountResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetConceptRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetConcept(\Clarifai\Internal\_GetConceptRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetConcept',
        $argument,
        ['\Clarifai\Internal\_SingleConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_ListConceptsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListConcepts(\Clarifai\Internal\_ListConceptsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListConcepts',
        $argument,
        ['\Clarifai\Internal\_MultiConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostConceptsSearchesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostConceptsSearches(\Clarifai\Internal\_PostConceptsSearchesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostConceptsSearches',
        $argument,
        ['\Clarifai\Internal\_MultiConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostConceptsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostConcepts(\Clarifai\Internal\_PostConceptsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostConcepts',
        $argument,
        ['\Clarifai\Internal\_MultiConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PatchConceptsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PatchConcepts(\Clarifai\Internal\_PatchConceptsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PatchConcepts',
        $argument,
        ['\Clarifai\Internal\_MultiConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetVocabRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetVocab(\Clarifai\Internal\_GetVocabRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetVocab',
        $argument,
        ['\Clarifai\Internal\_SingleVocabResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_ListVocabsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListVocabs(\Clarifai\Internal\_ListVocabsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListVocabs',
        $argument,
        ['\Clarifai\Internal\_MultiVocabResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostVocabsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostVocabs(\Clarifai\Internal\_PostVocabsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostVocabs',
        $argument,
        ['\Clarifai\Internal\_MultiVocabResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PatchVocabsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PatchVocabs(\Clarifai\Internal\_PatchVocabsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PatchVocabs',
        $argument,
        ['\Clarifai\Internal\_MultiVocabResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_DeleteVocabRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteVocab(\Clarifai\Internal\_DeleteVocabRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteVocab',
        $argument,
        ['\Clarifai\Internal\Status\_BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_DeleteVocabsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteVocabs(\Clarifai\Internal\_DeleteVocabsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteVocabs',
        $argument,
        ['\Clarifai\Internal\Status\_BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_ListVocabConceptsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListVocabConcepts(\Clarifai\Internal\_ListVocabConceptsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListVocabConcepts',
        $argument,
        ['\Clarifai\Internal\_MultiConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostVocabConceptsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostVocabConcepts(\Clarifai\Internal\_PostVocabConceptsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostVocabConcepts',
        $argument,
        ['\Clarifai\Internal\_MultiConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_DeleteVocabConceptRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteVocabConcept(\Clarifai\Internal\_DeleteVocabConceptRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteVocabConcept',
        $argument,
        ['\Clarifai\Internal\Status\_BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_DeleteVocabConceptsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteVocabConcepts(\Clarifai\Internal\_DeleteVocabConceptsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteVocabConcepts',
        $argument,
        ['\Clarifai\Internal\Status\_BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetConceptLanguageRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetConceptLanguage(\Clarifai\Internal\_GetConceptLanguageRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetConceptLanguage',
        $argument,
        ['\Clarifai\Internal\_SingleConceptLanguageResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_ListConceptLanguagesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListConceptLanguages(\Clarifai\Internal\_ListConceptLanguagesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListConceptLanguages',
        $argument,
        ['\Clarifai\Internal\_MultiConceptLanguageResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostConceptLanguagesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostConceptLanguages(\Clarifai\Internal\_PostConceptLanguagesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostConceptLanguages',
        $argument,
        ['\Clarifai\Internal\_MultiConceptLanguageResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PatchConceptLanguagesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PatchConceptLanguages(\Clarifai\Internal\_PatchConceptLanguagesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PatchConceptLanguages',
        $argument,
        ['\Clarifai\Internal\_MultiConceptLanguageResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_ListConceptReferencesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListConceptReferences(\Clarifai\Internal\_ListConceptReferencesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListConceptReferences',
        $argument,
        ['\Clarifai\Internal\_MultiConceptReferenceResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_ListConceptRelationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListConceptRelations(\Clarifai\Internal\_ListConceptRelationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListConceptRelations',
        $argument,
        ['\Clarifai\Internal\_MultiConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetInputCountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetInputCount(\Clarifai\Internal\_GetInputCountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetInputCount',
        $argument,
        ['\Clarifai\Internal\_SingleInputCountResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_StreamInputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function StreamInputs(\Clarifai\Internal\_StreamInputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/StreamInputs',
        $argument,
        ['\Clarifai\Internal\_MultiInputResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetInputRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetInput(\Clarifai\Internal\_GetInputRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetInput',
        $argument,
        ['\Clarifai\Internal\_SingleInputResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_ListInputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListInputs(\Clarifai\Internal\_ListInputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListInputs',
        $argument,
        ['\Clarifai\Internal\_MultiInputResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostInputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostInputs(\Clarifai\Internal\_PostInputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostInputs',
        $argument,
        ['\Clarifai\Internal\_MultiInputResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PatchInputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PatchInputs(\Clarifai\Internal\_PatchInputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PatchInputs',
        $argument,
        ['\Clarifai\Internal\_MultiInputResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_DeleteInputRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteInput(\Clarifai\Internal\_DeleteInputRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteInput',
        $argument,
        ['\Clarifai\Internal\Status\_BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_DeleteInputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteInputs(\Clarifai\Internal\_DeleteInputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteInputs',
        $argument,
        ['\Clarifai\Internal\Status\_BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostModelOutputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostModelOutputs(\Clarifai\Internal\_PostModelOutputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostModelOutputs',
        $argument,
        ['\Clarifai\Internal\_MultiOutputResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostModelFeedbackRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostModelFeedback(\Clarifai\Internal\_PostModelFeedbackRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostModelFeedback',
        $argument,
        ['\Clarifai\Internal\Status\_BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetModel(\Clarifai\Internal\_GetModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetModel',
        $argument,
        ['\Clarifai\Internal\_SingleModelResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetModelOutputInfo(\Clarifai\Internal\_GetModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetModelOutputInfo',
        $argument,
        ['\Clarifai\Internal\_SingleModelResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_ListModelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListModels(\Clarifai\Internal\_ListModelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListModels',
        $argument,
        ['\Clarifai\Internal\_MultiModelResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostModelsSearchesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostModelsSearches(\Clarifai\Internal\_PostModelsSearchesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostModelsSearches',
        $argument,
        ['\Clarifai\Internal\_MultiModelResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostModelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostModels(\Clarifai\Internal\_PostModelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostModels',
        $argument,
        ['\Clarifai\Internal\_SingleModelResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PatchModelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PatchModels(\Clarifai\Internal\_PatchModelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PatchModels',
        $argument,
        ['\Clarifai\Internal\_MultiModelResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_DeleteModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteModel(\Clarifai\Internal\_DeleteModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteModel',
        $argument,
        ['\Clarifai\Internal\Status\_BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_DeleteModelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteModels(\Clarifai\Internal\_DeleteModelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteModels',
        $argument,
        ['\Clarifai\Internal\Status\_BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_ListModelInputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListModelInputs(\Clarifai\Internal\_ListModelInputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListModelInputs',
        $argument,
        ['\Clarifai\Internal\_MultiInputResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetModelVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetModelVersion(\Clarifai\Internal\_GetModelVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetModelVersion',
        $argument,
        ['\Clarifai\Internal\_SingleModelVersionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_ListModelVersionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListModelVersions(\Clarifai\Internal\_ListModelVersionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListModelVersions',
        $argument,
        ['\Clarifai\Internal\_MultiModelVersionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostModelVersionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostModelVersions(\Clarifai\Internal\_PostModelVersionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostModelVersions',
        $argument,
        ['\Clarifai\Internal\_SingleModelResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_DeleteModelVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteModelVersion(\Clarifai\Internal\_DeleteModelVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteModelVersion',
        $argument,
        ['\Clarifai\Internal\Status\_BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetModelVersionMetricsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetModelVersionMetrics(\Clarifai\Internal\_GetModelVersionMetricsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetModelVersionMetrics',
        $argument,
        ['\Clarifai\Internal\_SingleModelVersionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostModelVersionMetricsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostModelVersionMetrics(\Clarifai\Internal\_PostModelVersionMetricsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostModelVersionMetrics',
        $argument,
        ['\Clarifai\Internal\_SingleModelVersionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetWorkflowRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetWorkflow(\Clarifai\Internal\_GetWorkflowRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetWorkflow',
        $argument,
        ['\Clarifai\Internal\_SingleWorkflowResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_ListWorkflowsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListWorkflows(\Clarifai\Internal\_ListWorkflowsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListWorkflows',
        $argument,
        ['\Clarifai\Internal\_MultiWorkflowResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_ListPublicWorkflowsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListPublicWorkflows(\Clarifai\Internal\_ListPublicWorkflowsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListPublicWorkflows',
        $argument,
        ['\Clarifai\Internal\_MultiWorkflowResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostWorkflowsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostWorkflows(\Clarifai\Internal\_PostWorkflowsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostWorkflows',
        $argument,
        ['\Clarifai\Internal\_MultiWorkflowResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PatchWorkflowsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PatchWorkflows(\Clarifai\Internal\_PatchWorkflowsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PatchWorkflows',
        $argument,
        ['\Clarifai\Internal\_MultiWorkflowResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_DeleteWorkflowRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteWorkflow(\Clarifai\Internal\_DeleteWorkflowRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteWorkflow',
        $argument,
        ['\Clarifai\Internal\Status\_BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_DeleteWorkflowsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteWorkflows(\Clarifai\Internal\_DeleteWorkflowsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteWorkflows',
        $argument,
        ['\Clarifai\Internal\Status\_BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostWorkflowResultsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostWorkflowResults(\Clarifai\Internal\_PostWorkflowResultsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostWorkflowResults',
        $argument,
        ['\Clarifai\Internal\_PostWorkflowResultsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostSearchesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostSearches(\Clarifai\Internal\_PostSearchesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostSearches',
        $argument,
        ['\Clarifai\Internal\_MultiSearchResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostSearchFeedbackRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostSearchFeedback(\Clarifai\Internal\_PostSearchFeedbackRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostSearchFeedback',
        $argument,
        ['\Clarifai\Internal\Status\_BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetSubscriptionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetSubscription(\Clarifai\Internal\_GetSubscriptionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetSubscription',
        $argument,
        ['\Clarifai\Internal\_SingleSubscriptionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostSubscriptionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostSubscription(\Clarifai\Internal\_PostSubscriptionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostSubscription',
        $argument,
        ['\Clarifai\Internal\_SingleSubscriptionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetAppVisualizationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetAppVisualization(\Clarifai\Internal\_GetAppVisualizationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetAppVisualization',
        $argument,
        ['\Clarifai\Internal\_SingleVisualizationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetVisualizationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetVisualization(\Clarifai\Internal\_GetVisualizationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetVisualization',
        $argument,
        ['\Clarifai\Internal\_SingleVisualizationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_PostVisualizationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostVisualization(\Clarifai\Internal\_PostVisualizationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostVisualization',
        $argument,
        ['\Clarifai\Internal\_SingleVisualizationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_ListStatusCodesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListStatusCodes(\Clarifai\Internal\_ListStatusCodesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListStatusCodes',
        $argument,
        ['\Clarifai\Internal\_MultiStatusCodeResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetStatusCodeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetStatusCode(\Clarifai\Internal\_GetStatusCodeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetStatusCode',
        $argument,
        ['\Clarifai\Internal\_SingleStatusCodeResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Internal\_GetHealthzRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetHealthz(\Clarifai\Internal\_GetHealthzRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetHealthz',
        $argument,
        ['\Clarifai\Internal\_GetHealthzResponse', 'decode'],
        $metadata, $options);
    }

}
