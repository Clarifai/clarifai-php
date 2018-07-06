<?php

namespace Clarifai\DTOs\Models\OutputInfos;

use Clarifai\Internal\_OutputInfo;

interface OutputInfoInterface
{
    /**
     * @return string the type
     */
    function type();

    /**
     * @return string the type extension - it uniquely defines a model type
     */
    function typeExt();

    /**
     * @return string the message
     */
    function message();

    /**
     * @return _OutputInfo Serialized Protobuf object.
     */
    function serialize();
}