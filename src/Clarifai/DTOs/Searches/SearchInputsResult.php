<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\Internal\_Hit;
use Clarifai\Internal\_MultiSearchResponse;

class SearchInputsResult
{
    /**
     * @var string
     */
    private $id;
    /**
     * @return string
     */
    public function id() { return $this->id; }

    /**
     * @var SearchHit[]
     */
    private $searchHits;
    /**
     * @return SearchHit[]
     */
    public function searchHits() { return $this->searchHits; }

    /**
     * Ctor.
     * @param string $id
     * @param SearchHit[] $searchHits
     */
    private function __construct($id, $searchHits)
    {
        $this->id = $id;
        $this->searchHits = $searchHits;
    }

    /**
     * @param _MultiSearchResponse $response
     */
    public static function deserialize($response)
    {
        $searchHits = [];
        /** @var _Hit $hit */
        foreach ($response->getHits() as $hit) {
            array_push($searchHits, SearchHit::deserialize($hit));
        }
        return new SearchInputsResult($response->getId(), $searchHits);
    }
}
