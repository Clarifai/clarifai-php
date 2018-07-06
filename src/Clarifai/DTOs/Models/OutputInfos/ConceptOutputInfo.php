<?php

namespace Clarifai\DTOs\Models\OutputInfos;

use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Internal\_Data;
use Clarifai\Internal\_OutputConfig;
use Clarifai\Internal\_OutputInfo;

class ConceptOutputInfo implements OutputInfoInterface
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

    private $concepts;
    /**
     * @return Concept[] The concepts.
     */
    function concepts() { return $this->concepts; }

    private $areConceptsMutuallyExclusive;
    /**
     * @return bool Whether the concepts are mutually exclusive.
     */
    function areConceptsMutuallyExclusive() { return $this->areConceptsMutuallyExclusive; }

    private $isEnvironmentClosed;
    /**
     * @return bool Whether the concept environment is closed.
     */
    function isEnvironmentClosed() { return $this->isEnvironmentClosed; }

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
     * @param Concept[] $concepts The concepts.
     * @param bool $areConceptsMutuallyExclusive Are concepts mutually exclusive.
     * @param bool $isEnvironmentClosed Is concept environment closed.
     * @param string $language The language.
     */
    public function __construct($type, $typeExt, $message, $concepts,
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
            $outputConfig->setLanguage($this->language);
        }

        return (new _OutputInfo())
            ->setData((new _Data())
                ->setConcepts($concepts))
            ->setOutputConfig($outputConfig);
    }

    /**
     * @param _OutputInfo $outputInfoResponse
     * @return ConceptOutputInfo
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
        return new ConceptOutputInfo($outputInfoResponse->getType(),
            $outputInfoResponse->getTypeExt(), $outputInfoResponse->getMessage(), $concepts,
            $areConceptsMutuallyExclusive, $isEnvironmentClosed, $language);
    }
}
