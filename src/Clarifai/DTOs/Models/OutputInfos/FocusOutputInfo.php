<?php

namespace Clarifai\DTOs\Models\OutputInfos;

use Clarifai\Internal\_OutputInfo;

/**
 * Certain information regarding the Focus model.
 */
class FocusOutputInfo implements OutputInfoInterface
{
    private $type;
    /**
     * @inheritdoc
     */
    function type() { return $this->type; }

    private $typeExt;
    /**
     * @inheritdoc
     */
    function typeExt() { return $this->typeExt; }

    private $message;
    /**
     * @inheritdoc
     */
    function message() { return $this->message; }

    /**
     * Ctor.
     * @param string $type The type.
     * @param string $typeExt The type ext.
     * @param string $message The message.
     */
    public function __construct($type, $typeExt, $message)
    {
        $this->type = $type;
        $this->typeExt = $typeExt;
        $this->message = $message;
    }

    /**
     * @inheritdoc
     */
    public function serialize()
    {
        return new _OutputInfo();
    }

    /**
     * @param _OutputInfo $outputInfoResponse
     * @return FocusOutputInfo
     */
    public static function deserialize($outputInfoResponse)
    {
        return new FocusOutputInfo($outputInfoResponse->getType(),
            $outputInfoResponse->getTypeExt(), $outputInfoResponse->getMessage());
    }
}
