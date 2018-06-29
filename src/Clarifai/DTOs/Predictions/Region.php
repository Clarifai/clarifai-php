<?php

namespace Clarifai\DTOs\Predictions;

class Region
{
    private $id;
    private $crop;
    private $concepts;

    public function __construct($id, $crop, $concepts)
    {
    }
}
