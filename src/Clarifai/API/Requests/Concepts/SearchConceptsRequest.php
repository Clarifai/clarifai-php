<?php

namespace Clarifai\API\Requests\Concepts;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiPaginatedRequest;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Internal\_Concept;
use Clarifai\Internal\_ConceptQuery;
use Clarifai\Internal\_MultiConceptResponse;
use Clarifai\Internal\_PostConceptsSearchesRequest;

class SearchConceptsRequest extends ClarifaiPaginatedRequest
{
    /**
     * @var string
     */
    private $query;


    private $language;
    /**
     * @param string $language The language.
     * @return $this The same request object instance.
     */
    public function withLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Ctor.
     * @param ClarifaiHttpClientInterface $httpClient The Clarifai HTTP client.
     * @param string $query The query to search concepts by.
     */
    public function __construct(ClarifaiHttpClientInterface $httpClient, $query)
    {
        parent::__construct($httpClient);
        $this->query = $query;
    }

    protected function requestMethod()
    {
        return RequestMethod::POST;
    }

    protected function url()
    {
        return '/v2/concepts/searches';
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $conceptQuery = (new _ConceptQuery())
            ->setName($this->query);
        if (!is_null($this->language)) {
            $conceptQuery->setLanguage($this->language);
        }
        return $grpcClient->PostConceptsSearches((new _PostConceptsSearchesRequest())
            ->setConceptQuery($conceptQuery));
    }

    /**
     * @param _MultiConceptResponse $response
     * @return Concept[] An array of concepts.
     */
    protected function unmarshaller($response)
    {
        $concepts = [];
        /** @var _Concept $conceptResponse */
        foreach ($response->getConcepts() as $conceptResponse) {
            array_push($concepts, Concept::deserialize($conceptResponse));
        }
        return $concepts;
    }
}
