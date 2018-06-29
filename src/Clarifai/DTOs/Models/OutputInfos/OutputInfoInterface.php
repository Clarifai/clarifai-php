<?php

namespace Clarifai\DTOs\Models\OutputInfos;

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
     * @return \Clarifai\Grpc\OutputInfo Serialized Protobuf object.
     */
    function serialize();
}