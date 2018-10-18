<?php

namespace Clarifai\Solutions;

use Clarifai\Solutions\Moderation\Moderation;

class Solutions
{
    private $moderation;

    /**
     * Ctor.
     * @param string $apiKey The Clarifai API key.
     */
    public function __construct($apiKey)
    {
        $this->moderation = new Moderation($apiKey);
    }

    /**
     * @return Moderation The Moderation solution
     */
    public function moderation()
    {
        return $this->moderation;
    }
}
