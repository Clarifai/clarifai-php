<?php

namespace Clarifai\DTOs\Inputs;
use Clarifai\Internal\_InputCount;

/**
 * Returns the status of inputs processing.
 */
class ClarifaiInputsStatus
{
    private $processed;
    /**
     * @return int Number of inputs that have been procesed.
     */
    public function processed() { return $this->processed; }

    private $toProcess;
    /**
     * @return int Number of inputs that are yet to be processed.
     */
    public function toProcess() { return $this->toProcess; }

    private $errors;
    /**
     * @return int Number of inputs that weren't able to be processed.
     */
    public function errors() { return $this->errors; }

    private $processing;
    /**
     * @return int Number of inputs that are being processed.
     */
    public function processing() { return $this->processing; }

    private function __construct($processed, $toProcess, $errors, $processing)
    {
        $this->processed = $processed;
        $this->toProcess = $toProcess;
        $this->errors = $errors;
        $this->processing = $processing;
    }

    /**
     * @param _InputCount $inputCountResponse
     * @return ClarifaiInputsStatus Deserializes the object from a Protobuf object.
     */
    public static function deserialize($inputCountResponse)
    {
        return new ClarifaiInputsStatus($inputCountResponse->getProcessed(),
            $inputCountResponse->getToProcess(), $inputCountResponse->getErrors(),
            $inputCountResponse->getProcessing());
    }
}
