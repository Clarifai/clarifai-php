<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: proto/clarifai/api/status/status.proto

namespace GPBMetadata\Proto\Clarifai\Api\Status;

class Status
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Proto\Clarifai\Api\Status\StatusCode::initOnce();
        $pool->internalAddGeneratedFile(hex2bin(
            "0ad5020a2670726f746f2f636c6172696661692f6170692f737461747573" .
            "2f7374617475732e70726f746f1213636c6172696661692e6170692e7374" .
            "6174757322a0010a06537461747573122d0a04636f646518012001280e32" .
            "1f2e636c6172696661692e6170692e7374617475732e537461747573436f" .
            "646512130a0b6465736372697074696f6e180220012809120f0a07646574" .
            "61696c7318032001280912190a1170657263656e745f636f6d706c657465" .
            "6418052001280d12160a0e74696d655f72656d61696e696e671806200128" .
            "0d120e0a067265715f6964180720012809223b0a0c42617365526573706f" .
            "6e7365122b0a0673746174757318012001280b321b2e636c617269666169" .
            "2e6170692e7374617475732e537461747573422e5a06737461747573a202" .
            "0443414950c202015fca0218436c6172696661695c496e7465726e616c5c" .
            "537461747573620670726f746f33"
        ));

        static::$is_initialized = true;
    }
}

