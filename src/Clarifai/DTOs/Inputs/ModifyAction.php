<?php

namespace Clarifai\DTOs\Inputs;

/**
 * A type of modification.
 */
class ModifyAction
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
     * @return ModifyAction Merge will overwrite overwrite a key:value or append to an existing
     * list of values.
     */
    public static function merge() { return new ModifyAction('merge'); }

    /**
     * @return ModifyAction Overwrite will overwrite a key:value or overwrite a list of values.
     */
    public static function overwrite() { return new ModifyAction('overwrite'); }

    /**
     * @return ModifyAction Remove will overwrite a key:value or delete anything in a list that
     * matches the provided values' ids.
     */
    public static function remove() { return new ModifyAction('remove'); }

    public function serialize()
    {
        return $this->value;
    }
}
