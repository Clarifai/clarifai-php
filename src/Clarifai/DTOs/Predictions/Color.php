<?php

namespace Clarifai\DTOs\Predictions;

use Clarifai\Internal\_Color;

/**
 * Represents a color associated with a certain input.
 */
class Color implements PredictionInterface
{
    /**
     * @inheritdoc
     */
    public function type() { return 'concept'; }

    private $rawHex;
    /**
     * @return string Raw hex.
     */
    public function rawHex() { return $this->rawHex; }

    private $hex;
    /**
     * @return string Web safe hex.
     */
    public function hex() { return $this->hex; }

    private $name;
    /**
     * @return string Web safe color name.
     */
    public function name() { return $this->name; }

    private $value;
    /**
     * @return float Value of the color. Only used in association with an input.
     */
    public function value() { return $this->value; }

    /**
     * Ctor.
     * @param string $rawHex The raw hex.
     * @param string $hex The web safe hex.
     * @param string $name The name.
     * @param float $value The value.
     */
    private function __construct($rawHex, $hex, $name, $value)
    {
        $this->rawHex = $rawHex;
        $this->hex = $hex;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @param _Color $colorResponse
     * @return Color
     */
    public static function deserialize($colorResponse)
    {
        return new Color($colorResponse->getRawHex(), $colorResponse->getW3C()->getHex(),
            $colorResponse->getW3C()->getName(), $colorResponse->getValue());
    }
}
