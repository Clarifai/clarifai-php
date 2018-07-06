<?php

namespace Clarifai\DTOs\Models\OutputInfos;

use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_OutputConfig;
use Clarifai\Internal\_OutputInfo;

/**
 * Certain information regarding the FaceConcepts model.
 */
class FaceConceptsOutputInfo implements OutputInfoInterface
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
     * @var Concept[]
     */
    private $concepts;
    /**
     * @return Concept[] The concepts.
     */
    function concepts() { return $this->concepts; }

    /**
     * @var bool|null
     */
    private $areConceptsMutuallyExclusive;
    /**
     * @return bool Whether the concepts are mutually exclusive.
     */
    function areConceptsMutuallyExclusive() { return $this->areConceptsMutuallyExclusive; }

    /**
     * @var string|null
     */
    private $isEnvironmentClosed;
    /**
     * @return bool Whether the concept environment is closed.
     */
    function isEnvironmentClosed() { return $this->isEnvironmentClosed; }

    /**
     * @var string|null
     */
    private $language;
    /**
     * @return string The language.
     */
    function language() { return $this->language; }

    /**
     * Ctor.
     * @param string $type The type.
     * @param string $typeExt The type ext.
     * @param string $message The message.
     * @param Concept[] $concepts
     * @param bool $areConceptsMutuallyExclusive
     * @param string $isEnvironmentClosed
     * @param string $language
     */
    private function __construct($type, $typeExt, $message, $concepts = null,
        $areConceptsMutuallyExclusive = null, $isEnvironmentClosed = null, $language = null)
    {
        $this->type = $type;
        $this->typeExt = $typeExt;
        $this->message = $message;
        $this->concepts = $concepts;
        $this->areConceptsMutuallyExclusive = $areConceptsMutuallyExclusive;
        $this->isEnvironmentClosed = $isEnvironmentClosed;
        $this->language = $language;
    }

    /**
     * An object creator that's to be used when creating a custom face concept model.
     *
     * @param Concept[] $concepts
     * @param bool|null $areConceptsMutuallyExclusive
     * @param bool|null $isEnvironmentClosed
     * @param string|null $language
     * @return FaceConceptsOutputInfo
     */
    public static function make($concepts, $areConceptsMutuallyExclusive = null,
        $isEnvironmentClosed = null, $language = null)
    {
        return new FaceConceptsOutputInfo(null, null, null, $concepts,
            $areConceptsMutuallyExclusive, $isEnvironmentClosed, $language);
    }

    /**
     * @inheritdoc
     */
    public function serialize()
    {
        $concepts = [];
        foreach ($this->concepts as $concept) {
            array_push($concepts, $concept->serialize());
        }

        $outputConfig = (new _OutputConfig())
            ->setConceptsMutuallyExclusive($this->areConceptsMutuallyExclusive)
            ->setClosedEnvironment($this->isEnvironmentClosed);
        if (!is_null($this->language)) {
            $outputConfig->setLanguage('en');
        }

        $outputInfo = (new _OutputInfo())
            ->setData((new _Data())
                ->setConcepts($concepts));

        if ($outputConfig->byteSize() > 0) {
            $outputInfo->setOutputConfig($outputConfig);
        }

        return $outputInfo;
    }

    /**
     * @param _OutputInfo $outputInfoResponse
     * @return FaceConceptsOutputInfo
     */
    public static function deserialize($outputInfoResponse)
    {
        $concepts = null;
        $dataResponse = $outputInfoResponse->getData();
        if (!is_null($dataResponse)) {
            $conceptsResponse = $dataResponse->getConcepts();
            if (!is_null(($conceptsResponse))) {
                $concepts = [];
                foreach ($conceptsResponse as $concept) {
                    array_push($concepts, Concept::deserialize($concept));
                }
            }
        }
        $outputConfigResponse = $outputInfoResponse->getOutputConfig();
        if (!is_null($outputConfigResponse)) {
            $areConceptsMutuallyExclusive = $outputConfigResponse->getConceptsMutuallyExclusive();
            $isEnvironmentClosed = $outputConfigResponse->getClosedEnvironment();
            $language = $outputConfigResponse->getLanguage();
        } else {
            $areConceptsMutuallyExclusive = null;
            $isEnvironmentClosed = null;
            $language = null;
        }
        return new FaceConceptsOutputInfo($outputInfoResponse->getType(),
            $outputInfoResponse->getTypeExt(), $outputInfoResponse->getMessage(), $concepts,
            $areConceptsMutuallyExclusive, $isEnvironmentClosed, $language);
    }
}
