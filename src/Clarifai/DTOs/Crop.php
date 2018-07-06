<?php

namespace Clarifai\DTOs;

use Clarifai\Internal\_BoundingBox;

/**
 * Crop / bounding box. Crop points are percentages from the edge.
 * E.g. top of 0.2 means the cropped input will start 20% down from the original edge.
 */
class Crop
{
    private $top;
    private $left;
    private $bottom;
    private $right;

    /**
     * Ctor.
     * @param float $top top
     * @param float $left left
     * @param float $bottom bottom
     * @param float $right right
     */
    public function __construct($top, $left, $bottom, $right)
    {
        $this->top = $top;
        $this->left = $left;
        $this->bottom = $bottom;
        $this->right = $right;
    }

    /**
     * Serializes this object as an array of floats.
     * @return float[]
     */
    public function serializeAsArray()
    {
        return [$this->top, $this->left, $this->bottom, $this->right];
    }

    /**
     * Serializes this object to a Protobuf object.
     * @return _BoundingBox
     */
    public function serializeAsObject()
    {
        return (new _BoundingBox())
            ->setTopRow($this->top)
            ->setLeftCol($this->left)
            ->setBottomRow($this->bottom)
            ->setRightCol($this->right);
    }

    /**
     * @param _BoundingBox|\Google\Protobuf\Internal\RepeatedField $boxResponse
     * @return Crop
     */
    public static function deserialize($boxResponse)
    {
        if ($boxResponse instanceof \Google\Protobuf\Internal\RepeatedField) {
            return new Crop($boxResponse->offsetGet(0), $boxResponse->offsetGet(1),
                $boxResponse->offsetGet(2), $boxResponse->offsetGet(3));
        } else {
            return new Crop($boxResponse->getTopRow(), $boxResponse->getLeftCol(),
                $boxResponse->getBottomRow(), $boxResponse->getRightCol());
        }
    }
}