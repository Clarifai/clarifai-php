<?php

namespace Clarifai\DTOs;

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
     * @return string|null The error details.
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
            if ($statusResponse->getCode() === 10010) {
                $statusType = StatusType::mixedSuccess();
            } else {
                $statusType = StatusType::successful();
            }
        } else {
            $statusType = StatusType::failure();
        }
        return new ClarifaiStatus(
            $statusType,
            $statusResponse->getCode(),
            $statusResponse->getDescription(),
            $statusResponse->getDetails()
        );
    }

    /**
     * @param array $jsonObject The response JSON object.
     * @param int $httpStatusCode The HTTP status code.
     * @return ClarifaiStatus The ClarifaiStatus object.
     */
    public static function deserializeJson($jsonObject, $httpStatusCode = 200)
    {
        if (200 <= $httpStatusCode && $httpStatusCode < 300) {
            if ($jsonObject['code'] === 10010) {
                $statusType = StatusType::mixedSuccess();
            } else {
                $statusType = StatusType::successful();
            }
        } else {
            $statusType = StatusType::failure();
        }
        return new ClarifaiStatus(
            $statusType,
            $jsonObject['code'],
            $jsonObject['descriptions'],
            array_key_exists('details', $jsonObject) ? $jsonObject['details'] : null
        );
    }
}
