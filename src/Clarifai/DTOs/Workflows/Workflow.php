<?php

namespace Clarifai\DTOs\Workflows;

use Clarifai\Internal\_Workflow;

class Workflow
{
    /**
     * @var string
     */
    private $id;
    /**
     * @return string The ID.
     */
    public function id() { return $this->id; }

    /**
     * @var string
     */
    private $appID;
    /**
     * @return string The app ID.
     */
    public function appID() { return $this->appID; }

    /**
     * @var \DateTime
     */
    private $createdAt;
    /**
     * @return \DateTime DateTime of creation.
     */
    public function createdAt() { return $this->createdAt; }

    /**
     * Ctor.
     * @param string $id
     * @param string $appID
     * @param \DateTime $createdAt
     */
    private function __construct($id, $appID, $createdAt)
    {
        $this->id = $id;
        $this->appID = $appID;
        $this->createdAt = $createdAt;
    }

    /**
     * @param _Workflow $workflowResponse
     * @return Workflow
     */
    public static function deserialize($workflowResponse)
    {
        return new Workflow($workflowResponse->getId(), $workflowResponse->getAppId(),
            $workflowResponse->getCreatedAt()->toDateTime());
    }
}
