<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: proto/clarifai/api/face.proto

namespace Clarifai\Internal;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>clarifai.api.FaceAge</code>
 */
class _FaceAge extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>repeated .clarifai.api.Concept concepts = 1;</code>
     */
    private $concepts;

    public function __construct() {
        \GPBMetadata\Proto\Clarifai\Api\Face::initOnce();
        parent::__construct();
    }

    /**
     * Generated from protobuf field <code>repeated .clarifai.api.Concept concepts = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getConcepts()
    {
        return $this->concepts;
    }

    /**
     * Generated from protobuf field <code>repeated .clarifai.api.Concept concepts = 1;</code>
     * @param \Clarifai\Internal\_Concept[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setConcepts($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Clarifai\Internal\_Concept::class);
        $this->concepts = $arr;

        return $this;
    }

}

