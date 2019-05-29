<?php

namespace Clarifai\DTOs\Inputs;

class InputType
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
     * @return InputType Image input type.
     */
    public static function image() { return new InputType('image'); }

    /**
     * @return InputType Video input type.
     */
    public static function video() { return new InputType('video'); }

    public function __toString()
    {
        return $this->value;
    }
}

