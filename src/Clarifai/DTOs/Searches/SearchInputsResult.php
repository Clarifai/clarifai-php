<?php

namespace Clarifai\DTOs\Searches;

use Clarifai\Grpc\MultiSearchResponse;

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
     * @param MultiSearchResponse $response
     */
    public static function deserialize($response)
    {
        $searchHits = [];
        /** @var \Clarifai\Grpc\Hit $hit */
        foreach ($response->getHits() as $hit) {
            array_push($searchHits, SearchHit::deserialize($hit));
        }
        return new SearchInputsResult($response->getId(), $searchHits);
    }
}
