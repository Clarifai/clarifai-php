<?php

namespace Clarifai\API\Requests\Feedbacks;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Feedbacks\ConceptFeedback;
use Clarifai\DTOs\Feedbacks\RegionFeedback;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_EventType;
use Clarifai\Internal\_FeedbackInfo;
use Clarifai\Internal\_Image;
use Clarifai\Internal\_Input;
use Clarifai\Internal\_PostModelFeedbackRequest;
use Clarifai\Internal\Status\_BaseResponse;

class ModelFeedbackRequest extends ClarifaiRequest
{
    /**
     * @var string
     */
    private $modelID;
    /**
     * @var string
     */
    private $imageURL;
    /**
     * @var string
     */
    private $inputID;
    /**
     * @var string
     */
    private $outputID;
    /**
     * @var string
     */
    private $endUserID;
    /**
     * @var string
     */
    private $sessionID;

    private $conceptFeedbacks = null;
    /**
     * @param ConceptFeedback[] $conceptFeedbacks
     * @return $this
     */
    public function withConceptFeedbacks($conceptFeedbacks)
    {
        $this->conceptFeedbacks = $conceptFeedbacks;
        return $this;
    }

    private $regionFeedbacks = null;
    /**
     * @param RegionFeedback[] $regionFeedbacks
     * @return $this
     */
    public function withRegionFeedbacks($regionFeedbacks)
    {
        $this->regionFeedbacks = $regionFeedbacks;
        return $this;
    }

    private $modelVersionID = null;
    /**
     * @param string $modelVersionID
     * @return $this
     */
    public function withModelVersionID($modelVersionID)
    {
        $this->modelVersionID = $modelVersionID;
        return $this;
    }

    /**
     * Ctor.
     * @param ClarifaiClientInterface $client The Clarifai ID.
     * @param string $modelID The model ID
     * @param string $imageURL The image URL.
     * @param string $inputID The input ID.
     * @param string $outputID The output ID.
     * @param string $endUserID The end user ID.
     * @param string $sessionID The session ID.
     */
    public function __construct(ClarifaiClientInterface $client, $modelID, $imageURL, $inputID,
        $outputID, $endUserID, $sessionID)
    {
        parent::__construct($client);
        $this->modelID = $modelID;
        $this->imageURL = $imageURL;
        $this->inputID = $inputID;
        $this->outputID = $outputID;
        $this->endUserID = $endUserID;
        $this->sessionID = $sessionID;
    }

    protected function requestMethod()
    {
        return RequestMethod::POST;
    }

    protected function url()
    {
        if (is_null($this->modelVersionID)) {
            return "/v2/models/$this->modelID/feedback";
        } else {
            return "/v2/models/$this->modelID/versions/$this->modelVersionID/feedback";
        }
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $data = (new _Data())
            ->setImage((new _Image())
                ->setUrl($this->imageURL));
        if (!is_null($this->conceptFeedbacks)) {
            $concepts = [];
            /** @var ConceptFeedback $conceptFeedback */
            foreach ($this->conceptFeedbacks as $conceptFeedback) {
                array_push($concepts, $conceptFeedback->serialize());
            }
            $data->setConcepts($concepts);
        }
        if (!is_null($this->regionFeedbacks)) {
            $regions = [];
            /** @var RegionFeedback $regionFeedback */
            foreach ($this->regionFeedbacks as $regionFeedback) {
                array_push($regions, $regionFeedback->serialize());
            }
            $data->setRegions($regions);
        }
        return $grpcClient
            ->PostModelFeedback((new _PostModelFeedbackRequest())
                ->setInput((new _Input())
                    ->setId($this->inputID)
                    ->setData($data)
                    ->setFeedbackInfo((new _FeedbackInfo())
                        ->setEventType(_EventType::annotation)
                        ->setOutputId($this->outputID)
                        ->setEndUserId($this->endUserID)
                        ->setSessionId($this->sessionID))));
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
