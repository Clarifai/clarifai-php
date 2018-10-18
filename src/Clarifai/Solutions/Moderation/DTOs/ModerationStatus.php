<?php

namespace Clarifai\Solutions\Moderation\DTOs;

class ModerationStatus
{
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

    private $inputID;
    /**
     * @return string|null The input ID.
     */
    public function inputID() { return $this->inputID; }

    private $details;
    /**
     * @return ModerationDetail[] The moderation details.
     */
    public function details() { return $this->details; }

    /**
     * Ctor.
     * @param int $statusCode
     * @param string $description
     * @param string $inputID
     * @param ModerationDetail[] $details
     */
    private function __construct($statusCode, $description, $inputID, $details)
    {
        $this->statusCode = $statusCode;
        $this->description = $description;
        $this->inputID = $inputID;
        $this->details = $details;
    }

    /**
     * @param array $jsonObject
     * @return ModerationStatus
     */
    public static function deserializeJson($jsonObject)
    {
        $inputID = null;
        if (array_key_exists('input_id', $jsonObject)) {
            $inputID = $jsonObject['input_id'];
        }
        $details = [];
        if (array_key_exists('details', $jsonObject)) {
            foreach ($jsonObject['details'] as $moderationDetail) {
                array_push($details, ModerationDetail::deserializeJson($moderationDetail));
            }
        }
        return new ModerationStatus(
            $jsonObject['code'],
            $jsonObject['description'],
            $inputID,
            $details
        );
    }
}
