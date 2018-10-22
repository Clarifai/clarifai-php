<?php

namespace Clarifai\API\Requests\Inputs;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Feedbacks\RegionFeedback;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Inputs\ModifyAction;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Helpers\ProtobufHelper;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_Input;
use Clarifai\Internal\_MultiInputResponse;
use Clarifai\Internal\_PatchInputsRequest;

/**
 * A request for input modification.
 */
class ModifyInputRequest extends ClarifaiRequest
{
    private $inputID;
    private $action;

    /* @var Concept[] $positiveConcepts */
    private $positiveConcepts;

    /**
     * @param Concept[] $val
     * @return $this
     */
    public function withPositiveConcepts($val) { $this->positiveConcepts = $val; return $this; }

    /* @var Concept[] $negativeConcepts */
    private $negativeConcepts;
    /**
     * @param Concept[] $val
     * @return $this
     */
    public function withNegativeConcepts($val) { $this->negativeConcepts = $val; return $this; }

    private $metadata;
    /**
     * @param array $val The metadata.
     * @return $this This instance.
     */
    public function withMetadata($val) { $this->metadata = $val; return $this; }

    /** @var RegionFeedback[] */
    private $regionFeedbacks;
    /**
     * @param RegionFeedback[] $array
     * @return $this
     */
    public function withRegionFeedbacks($val) { $this->regionFeedbacks = $val; return $this; }

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     * @param string $inputID the input ID
     * @param ModifyAction $action the modification action
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient, $inputID, $action)
    {
        parent::__construct($httpClient);
        $this->inputID = $inputID;
        $this->action = $action;
    }

    protected function requestMethod()
    {
        return RequestMethod::PATCH;
    }

    protected function url()
    {
        return '/v2/inputs';
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $data = new _Data();

        $concepts = [];
        if ($this->positiveConcepts) {
            foreach ($this->positiveConcepts as $concept) {
                array_push($concepts, $concept->serialize(true));
            }
        }
        if ($this->negativeConcepts) {
            foreach ($this->negativeConcepts as $concept) {
                array_push($concepts, $concept->serialize(false));
            }
        }
        $data->setConcepts($concepts);

        if (!is_null($this->metadata)) {
            $pbh = new ProtobufHelper();
            $data->setMetadata($pbh->arrayToStruct($this->metadata));
        }

        if (!is_null($this->regionFeedbacks)) {
            $regionFeedbacks = [];
            foreach ($this->regionFeedbacks as $regionFeedback) {
                array_push($regionFeedbacks, $regionFeedback->serialize());
            }
            $data->setRegions($regionFeedbacks);
        }

        return $grpcClient->PatchInputs((new _PatchInputsRequest())
            ->setAction($this->action->serialize())
            ->setInputs([
                (new _Input())
                    ->setId($this->inputID)
                    ->setData($data)]));
    }

    /**
     * @param _MultiInputResponse $inputsResponse The inputs.
     * @return \Clarifai\DTOs\Inputs\ClarifaiInput The ClarifaiInput object.
     * @throws \Clarifai\Exceptions\ClarifaiException
     */
    protected function unmarshaller($inputsResponse)
    {
        /** @var _Input[] $inputs */
        $inputs = $inputsResponse->getInputs();
        // Since only one input was added, only one output should be present.
        return ClarifaiInput::deserialize($inputs[0]);
    }
}
