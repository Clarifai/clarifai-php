<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Clarifai\Grpc;

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
     * @param \Clarifai\Grpc\TestMessage $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Echo(\Clarifai\Grpc\TestMessage $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/Echo',
        $argument,
        ['\Clarifai\Grpc\TestMessage', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetConceptCountsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetConceptCounts(\Clarifai\Grpc\GetConceptCountsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetConceptCounts',
        $argument,
        ['\Clarifai\Grpc\MultiConceptCountResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetConceptRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetConcept(\Clarifai\Grpc\GetConceptRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetConcept',
        $argument,
        ['\Clarifai\Grpc\SingleConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\ListConceptsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListConcepts(\Clarifai\Grpc\ListConceptsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListConcepts',
        $argument,
        ['\Clarifai\Grpc\MultiConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostConceptsSearchesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostConceptsSearches(\Clarifai\Grpc\PostConceptsSearchesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostConceptsSearches',
        $argument,
        ['\Clarifai\Grpc\MultiConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostConceptsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostConcepts(\Clarifai\Grpc\PostConceptsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostConcepts',
        $argument,
        ['\Clarifai\Grpc\MultiConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PatchConceptsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PatchConcepts(\Clarifai\Grpc\PatchConceptsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PatchConcepts',
        $argument,
        ['\Clarifai\Grpc\MultiConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetVocabRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetVocab(\Clarifai\Grpc\GetVocabRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetVocab',
        $argument,
        ['\Clarifai\Grpc\SingleVocabResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\ListVocabsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListVocabs(\Clarifai\Grpc\ListVocabsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListVocabs',
        $argument,
        ['\Clarifai\Grpc\MultiVocabResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostVocabsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostVocabs(\Clarifai\Grpc\PostVocabsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostVocabs',
        $argument,
        ['\Clarifai\Grpc\MultiVocabResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PatchVocabsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PatchVocabs(\Clarifai\Grpc\PatchVocabsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PatchVocabs',
        $argument,
        ['\Clarifai\Grpc\MultiVocabResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\DeleteVocabRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteVocab(\Clarifai\Grpc\DeleteVocabRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteVocab',
        $argument,
        ['\Clarifai\Grpc\Status\BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\DeleteVocabsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteVocabs(\Clarifai\Grpc\DeleteVocabsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteVocabs',
        $argument,
        ['\Clarifai\Grpc\Status\BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\ListVocabConceptsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListVocabConcepts(\Clarifai\Grpc\ListVocabConceptsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListVocabConcepts',
        $argument,
        ['\Clarifai\Grpc\MultiConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostVocabConceptsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostVocabConcepts(\Clarifai\Grpc\PostVocabConceptsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostVocabConcepts',
        $argument,
        ['\Clarifai\Grpc\MultiConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\DeleteVocabConceptRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteVocabConcept(\Clarifai\Grpc\DeleteVocabConceptRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteVocabConcept',
        $argument,
        ['\Clarifai\Grpc\Status\BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\DeleteVocabConceptsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteVocabConcepts(\Clarifai\Grpc\DeleteVocabConceptsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteVocabConcepts',
        $argument,
        ['\Clarifai\Grpc\Status\BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetConceptLanguageRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetConceptLanguage(\Clarifai\Grpc\GetConceptLanguageRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetConceptLanguage',
        $argument,
        ['\Clarifai\Grpc\SingleConceptLanguageResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\ListConceptLanguagesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListConceptLanguages(\Clarifai\Grpc\ListConceptLanguagesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListConceptLanguages',
        $argument,
        ['\Clarifai\Grpc\MultiConceptLanguageResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostConceptLanguagesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostConceptLanguages(\Clarifai\Grpc\PostConceptLanguagesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostConceptLanguages',
        $argument,
        ['\Clarifai\Grpc\MultiConceptLanguageResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PatchConceptLanguagesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PatchConceptLanguages(\Clarifai\Grpc\PatchConceptLanguagesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PatchConceptLanguages',
        $argument,
        ['\Clarifai\Grpc\MultiConceptLanguageResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\ListConceptReferencesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListConceptReferences(\Clarifai\Grpc\ListConceptReferencesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListConceptReferences',
        $argument,
        ['\Clarifai\Grpc\MultiConceptReferenceResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\ListConceptRelationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListConceptRelations(\Clarifai\Grpc\ListConceptRelationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListConceptRelations',
        $argument,
        ['\Clarifai\Grpc\MultiConceptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetInputCountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetInputCount(\Clarifai\Grpc\GetInputCountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetInputCount',
        $argument,
        ['\Clarifai\Grpc\SingleInputCountResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\StreamInputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function StreamInputs(\Clarifai\Grpc\StreamInputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/StreamInputs',
        $argument,
        ['\Clarifai\Grpc\MultiInputResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetInputRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetInput(\Clarifai\Grpc\GetInputRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetInput',
        $argument,
        ['\Clarifai\Grpc\SingleInputResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\ListInputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListInputs(\Clarifai\Grpc\ListInputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListInputs',
        $argument,
        ['\Clarifai\Grpc\MultiInputResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostInputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostInputs(\Clarifai\Grpc\PostInputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostInputs',
        $argument,
        ['\Clarifai\Grpc\MultiInputResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PatchInputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PatchInputs(\Clarifai\Grpc\PatchInputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PatchInputs',
        $argument,
        ['\Clarifai\Grpc\MultiInputResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\DeleteInputRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteInput(\Clarifai\Grpc\DeleteInputRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteInput',
        $argument,
        ['\Clarifai\Grpc\Status\BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\DeleteInputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteInputs(\Clarifai\Grpc\DeleteInputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteInputs',
        $argument,
        ['\Clarifai\Grpc\Status\BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostModelOutputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostModelOutputs(\Clarifai\Grpc\PostModelOutputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostModelOutputs',
        $argument,
        ['\Clarifai\Grpc\MultiOutputResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostModelFeedbackRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostModelFeedback(\Clarifai\Grpc\PostModelFeedbackRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostModelFeedback',
        $argument,
        ['\Clarifai\Grpc\Status\BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetModel(\Clarifai\Grpc\GetModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetModel',
        $argument,
        ['\Clarifai\Grpc\SingleModelResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetModelOutputInfo(\Clarifai\Grpc\GetModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetModelOutputInfo',
        $argument,
        ['\Clarifai\Grpc\SingleModelResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\ListModelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListModels(\Clarifai\Grpc\ListModelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListModels',
        $argument,
        ['\Clarifai\Grpc\MultiModelResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostModelsSearchesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostModelsSearches(\Clarifai\Grpc\PostModelsSearchesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostModelsSearches',
        $argument,
        ['\Clarifai\Grpc\MultiModelResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostModelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostModels(\Clarifai\Grpc\PostModelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostModels',
        $argument,
        ['\Clarifai\Grpc\SingleModelResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PatchModelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PatchModels(\Clarifai\Grpc\PatchModelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PatchModels',
        $argument,
        ['\Clarifai\Grpc\MultiModelResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\DeleteModelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteModel(\Clarifai\Grpc\DeleteModelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteModel',
        $argument,
        ['\Clarifai\Grpc\Status\BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\DeleteModelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteModels(\Clarifai\Grpc\DeleteModelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteModels',
        $argument,
        ['\Clarifai\Grpc\Status\BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\ListModelInputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListModelInputs(\Clarifai\Grpc\ListModelInputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListModelInputs',
        $argument,
        ['\Clarifai\Grpc\MultiInputResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetModelVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetModelVersion(\Clarifai\Grpc\GetModelVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetModelVersion',
        $argument,
        ['\Clarifai\Grpc\SingleModelVersionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\ListModelVersionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListModelVersions(\Clarifai\Grpc\ListModelVersionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListModelVersions',
        $argument,
        ['\Clarifai\Grpc\MultiModelVersionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostModelVersionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostModelVersions(\Clarifai\Grpc\PostModelVersionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostModelVersions',
        $argument,
        ['\Clarifai\Grpc\SingleModelResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\DeleteModelVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteModelVersion(\Clarifai\Grpc\DeleteModelVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteModelVersion',
        $argument,
        ['\Clarifai\Grpc\Status\BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetModelVersionMetricsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetModelVersionMetrics(\Clarifai\Grpc\GetModelVersionMetricsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetModelVersionMetrics',
        $argument,
        ['\Clarifai\Grpc\SingleModelVersionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostModelVersionMetricsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostModelVersionMetrics(\Clarifai\Grpc\PostModelVersionMetricsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostModelVersionMetrics',
        $argument,
        ['\Clarifai\Grpc\SingleModelVersionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetWorkflowRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetWorkflow(\Clarifai\Grpc\GetWorkflowRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetWorkflow',
        $argument,
        ['\Clarifai\Grpc\SingleWorkflowResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\ListWorkflowsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListWorkflows(\Clarifai\Grpc\ListWorkflowsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListWorkflows',
        $argument,
        ['\Clarifai\Grpc\MultiWorkflowResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\ListPublicWorkflowsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListPublicWorkflows(\Clarifai\Grpc\ListPublicWorkflowsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListPublicWorkflows',
        $argument,
        ['\Clarifai\Grpc\MultiWorkflowResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostWorkflowsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostWorkflows(\Clarifai\Grpc\PostWorkflowsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostWorkflows',
        $argument,
        ['\Clarifai\Grpc\MultiWorkflowResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PatchWorkflowsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PatchWorkflows(\Clarifai\Grpc\PatchWorkflowsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PatchWorkflows',
        $argument,
        ['\Clarifai\Grpc\MultiWorkflowResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\DeleteWorkflowRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteWorkflow(\Clarifai\Grpc\DeleteWorkflowRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteWorkflow',
        $argument,
        ['\Clarifai\Grpc\Status\BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\DeleteWorkflowsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteWorkflows(\Clarifai\Grpc\DeleteWorkflowsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/DeleteWorkflows',
        $argument,
        ['\Clarifai\Grpc\Status\BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostWorkflowResultsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostWorkflowResults(\Clarifai\Grpc\PostWorkflowResultsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostWorkflowResults',
        $argument,
        ['\Clarifai\Grpc\PostWorkflowResultsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostSearchesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostSearches(\Clarifai\Grpc\PostSearchesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostSearches',
        $argument,
        ['\Clarifai\Grpc\MultiSearchResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostSearchFeedbackRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostSearchFeedback(\Clarifai\Grpc\PostSearchFeedbackRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostSearchFeedback',
        $argument,
        ['\Clarifai\Grpc\Status\BaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetSubscriptionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetSubscription(\Clarifai\Grpc\GetSubscriptionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetSubscription',
        $argument,
        ['\Clarifai\Grpc\SingleSubscriptionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostSubscriptionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostSubscription(\Clarifai\Grpc\PostSubscriptionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostSubscription',
        $argument,
        ['\Clarifai\Grpc\SingleSubscriptionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetAppVisualizationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetAppVisualization(\Clarifai\Grpc\GetAppVisualizationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetAppVisualization',
        $argument,
        ['\Clarifai\Grpc\SingleVisualizationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetVisualizationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetVisualization(\Clarifai\Grpc\GetVisualizationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetVisualization',
        $argument,
        ['\Clarifai\Grpc\SingleVisualizationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\PostVisualizationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PostVisualization(\Clarifai\Grpc\PostVisualizationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/PostVisualization',
        $argument,
        ['\Clarifai\Grpc\SingleVisualizationResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\ListStatusCodesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListStatusCodes(\Clarifai\Grpc\ListStatusCodesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/ListStatusCodes',
        $argument,
        ['\Clarifai\Grpc\MultiStatusCodeResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetStatusCodeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetStatusCode(\Clarifai\Grpc\GetStatusCodeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetStatusCode',
        $argument,
        ['\Clarifai\Grpc\SingleStatusCodeResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Clarifai\Grpc\GetHealthzRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetHealthz(\Clarifai\Grpc\GetHealthzRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/clarifai.api.V2/GetHealthz',
        $argument,
        ['\Clarifai\Grpc\GetHealthzResponse', 'decode'],
        $metadata, $options);
    }

}
