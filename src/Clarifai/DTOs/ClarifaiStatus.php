<?php

namespace Clarifai\DTOs;

/**
 * The status type of a response.
 */
class StatusType
{
    private $value;

    /**
     * Private ctor.
     * @param string $value the value
     */
    private function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return StatusType Successful response.
     */
    public static function successful() { return new StatusType('successful'); }

    /**
     * @return StatusType Part of the response was successful, part not successful.
     */
    public static function mixedSuccess() { return new StatusType('mixed_success'); }

    /**
     * @return StatusType Failed response.
     */
    public static function failure() { return new StatusType('failure'); }

    /**
     * @return StatusType Network error occured.
     */
    public static function networkError() { return new StatusType('network_error'); }

    public function __toString()
    {
        return (string) $this->value;
    }
}

class ClarifaiStatus
{
    private $statusType;
    /**
     * @return StatusType The status type.
     */
    public function type() { return $this->statusType; }

    private $statusCode;
    /**
     * @return int The status code.
     */
    public function statusCode() { return $this->statusCode; }

    private $description;
    /**
     * @return string The description.
     */
    public function description() { return $this->description; }

    private $errorDetails;
    /**
     * @return string The error details.
     */
    public function errorDetails() { return $this->errorDetails; }

    /**
     * Ctor.
     * @param StatusType $statusType The status type.
     * @param int $statusCode The status code.
     * @param string $description The description.
     * @param string $errorDetails The error details.
     */
    public function __construct($statusType, $statusCode, $description, $errorDetails)
    {
        $this->statusType = $statusType;
        $this->statusCode = $statusCode;
        $this->description = $description;
        $this->errorDetails = $errorDetails;
    }

    /**
     * @param \Clarifai\Internal\Status\_Status $statusResponse The status.
     * @param int $httpStatusCode The HTTP status code.
     * @return ClarifaiStatus The ClarifaiStatus object.
     */
    public static function deserialize($statusResponse, $httpStatusCode = 200)
    {
        if (200 <= $httpStatusCode && $httpStatusCode < 300) {
            if ($statusResponse->getCode() === 10010)
            {
                $statusType = StatusType::mixedSuccess();
            }
            else
            {
                $statusType = StatusType::successful();
            }
        } else {
            $statusType = StatusType::failure();
        }

        return new ClarifaiStatus($statusType, $statusResponse->getCode(),
            $statusResponse->getDescription(), $statusResponse->getDetails());
    }
}
