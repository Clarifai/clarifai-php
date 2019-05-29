<?php

namespace Clarifai\DTOs\Inputs;

class InputForm
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
     * @return InputForm URL input form.
     */
    public static function url() { return new InputForm('url'); }

    /**
     * @return InputForm File input form.
     */
    public static function file() { return new InputForm('file'); }

    public function __toString()
    {
        return $this->value;
    }
}
