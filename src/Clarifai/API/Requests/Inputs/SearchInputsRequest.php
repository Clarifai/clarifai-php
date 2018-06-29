<?php

namespace Clarifai\API\Requests\Inputs;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiPaginatedRequest;
use Clarifai\DTOs\Searches\SearchBy;
use Clarifai\DTOs\Searches\SearchInputsResult;
use Clarifai\Grpc\MultiSearchResponse;
use Clarifai\Grpc\PostSearchesRequest;
use Clarifai\Grpc\Query;

/**
 * A request for searching inputs.
 */
class SearchInputsRequest extends ClarifaiPaginatedRequest
{
    /**
     * @var SearchBy[]
     */
    private $searchBys;
    /**
     * @var string|null
     */
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
     * @param SearchBy[]|SearchBy $searchBys The search clauses.
     * @param string|null $language The language.
     */
    public function __construct(ClarifaiClientInterface $client, $searchBys, $language = null)
    {
        parent::__construct($client);
        $this->searchBys = is_array($searchBys) ? $searchBys : [$searchBys];
        $this->language = $language;
    }

    protected function requestMethod()
    {
        return RequestMethod::POST;
    }

    protected function url()
    {
        return '/v2/searches';
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        $clauses = [];
        foreach ($this->searchBys as $searchBy) {
            array_push($clauses, $searchBy->serialize());
        }
        $query = (new Query())
            ->setAnds($clauses);
        if (!is_null($this->language)) {
            $query->setLanguage($this->language);
        }
        return $grpcClient->PostSearches((new PostSearchesRequest())
            ->setQuery($query));
    }

    /**
     * @param MultiSearchResponse $response
     * @return SearchInputsResult
     */
    protected function unmarshaller($response)
    {
        return SearchInputsResult::deserialize($response);
    }
}
