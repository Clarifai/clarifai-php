<?php

namespace Clarifai\DTOs\Predictions;


interface PredictionInterface
{
    /**
     * @return string The type.
     */
    public function type();
}