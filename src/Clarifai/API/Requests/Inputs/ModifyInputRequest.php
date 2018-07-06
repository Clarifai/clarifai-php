<?php

namespace Clarifai\API\Requests\Inputs;

use Clarifai\Grpc\Input;
use Clarifai\Grpc\MultiInputResponse;
use Clarifai\Grpc\PatchInputsRequest;
use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Inputs\ModifyAction;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Helpers\ProtobufHelper;
use Google\Protobuf\Struct;

/**
 * A request for input modification.
 */
class ModifyInputRequest extends ClarifaiRequest
{
    private $inputID;
    private $action;

    /* @var Concept[] $positiveConcepts */
    private $positiveConcepts;
    public function withPositiveConcepts($val) { $this->positiveConcepts = $val; return $this; }

    /* @var Concept[] $negativeConcepts */
    private $negativeConcepts;
    public function withNegativeConcepts($val) { $this->negativeConcepts = $val; return $this; }

    private $metadata;
    /**
     * @param array $val The metadata.
     * @return $this This instance.
     */
    public function withMetadata($val) { $this->metadata = $val; return $this; }

    /**
     * Ctor.
     * @param ClarifaiClientInterface $client
     * @param string $inputID the input ID
     * @param ModifyAction $action the modification action
     */
    public function __construct(ClarifaiClientInterface $client, $inputID, $action)
    {
        parent::__construct($client);
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
        $data = new \Clarifai\Grpc\Data;

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
            $a = new ProtobufHelper();
            $data->setMetadata($a->arrayToStruct($this->metadata));
        }

        return $grpcClient->PatchInputs((new PatchInputsRequest())
            ->setAction($this->action->serialize())
            ->setInputs([
                (new \Clarifai\Grpc\Input())
                    ->setId($this->inputID)
                    ->setData($data)]));
    }

    /**
     * @param MultiInputResponse $inputsResponse The inputs.
     * @return \Clarifai\DTOs\Inputs\ClarifaiInput The ClarifaiInput object.
     * @throws \Clarifai\Exceptions\ClarifaiException
     */
    protected function unmarshaller($inputsResponse)
    {
        return ClarifaiInput::deserialize($inputsResponse->getInputs()[0]);
    }
}