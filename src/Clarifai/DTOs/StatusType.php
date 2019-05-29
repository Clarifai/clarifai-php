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
