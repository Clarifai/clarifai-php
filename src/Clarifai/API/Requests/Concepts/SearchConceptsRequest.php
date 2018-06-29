<?php

namespace Clarifai\API\Requests\Concepts;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiPaginatedRequest;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\Grpc\ConceptQuery;

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
     * @param ClarifaiClientInterface $client The Clarifai client.
     * @param string $query The query to search concepts by.
     */
    public function __construct(ClarifaiClientInterface $client, $query)
    {
        parent::__construct($client);
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
        $conceptQuery = (new ConceptQuery())
            ->setName($this->query);
        if (!is_null($this->language)) {
            $conceptQuery->setLanguage($this->language);
        }
        return $grpcClient->PostConceptsSearches((new \Clarifai\Grpc\PostConceptsSearchesRequest())
            ->setConceptQuery($conceptQuery));
    }

    /**
     * @param \Clarifai\Grpc\MultiConceptResponse $response
     * @return Concept[] An array of concepts.
     */
    protected function unmarshaller($response)
    {
        $concepts = [];
        /** @var \Clarifai\Grpc\Concept $conceptResponse */
        foreach ($response->getConcepts() as $conceptResponse) {
            array_push($concepts, Concept::deserialize($conceptResponse));
        }
        return $concepts;
    }
}
