<?php

namespace Clarifai\Helpers;

use Clarifai\Exceptions\ClarifaiException;
use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\MapField;
use Google\Protobuf\Struct;
use Google\Protobuf\Value;

class ProtobufHelper
{
    /**
     * @param array $arr
     * @return Struct
     */
    public function arrayToStruct($arr)
    {
        return (new Struct())->setFields($this->arrayToMapField($arr));
    }

    /**
     * Converts an associative array to a Struct.
     * @param array $arr The array to convert.
     * @return MapField
     */
    public function arrayToMapField($arr)
    {
        $s = new MapField(GPBType::STRING, GPBType::MESSAGE, \Google\Protobuf\Value::class);
        foreach ($arr as $key => $value) {
            $s[$key] = new Value();
            if (is_array($value)) {
                $s[$key]->setStructValue($this->arrayToStruct($value));
            } else {
                $s[$key]->setStringValue($value);
            }
        }
        return $s;
    }

    /**
     * @param Struct $struct
     * @return array
     */
    public function structToArray($struct)
    {
        $arr = [];
        /**
         * @var String $key
         * @var Value $value
         */
        foreach ($struct->getFields() as $key => $value) {
            switch ($value->getKind()) {
                case 'struct_value':
                    {
                        $convertedValue = $this->structToArray($value->getStructValue());
                        break;
                    }
                case 'string_value':
                    {
                        $convertedValue = $value->getStringValue();
                        break;
                    }
                case 'number_value':
                    {
                        $convertedValue = $value->getNumberValue();
                        break;
                    }
                case 'bool_value':
                    {
                        $convertedValue = $value->getBoolValue();
                        break;
                    }
                default:
                    {
                        throw new ClarifaiException('Cannot handle Protobuf struct type ' .
                            $value->getKind());
                    }
            }

            $arr[$key] = $convertedValue;
        }

        return $arr;
    }
}
