<?php

namespace Integration;

use Clarifai\DTOs\Crop;
use Clarifai\DTOs\GeoPoint;
use Clarifai\DTOs\GeoRadius;
use Clarifai\DTOs\GeoRadiusUnit;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Searches\SearchBy;
use Clarifai\DTOs\Searches\SearchInputsResult;

class SearchInputsIntTest extends BaseInt
{
    public function testSearchInputsByConceptID()
    {
        $response = $this->client->searchInputs(SearchBy::conceptID('ai_mFqxrph2'))
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->get()->searchHits());
    }

    public function testSearchInputsByUserTaggedConceptID()
    {
        $response = $this->client->searchInputs(SearchBy::userTaggedConceptID('cat'))
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->get()->searchHits());
    }

    public function testSearchInputsByConceptName()
    {
        $response = $this->client->searchInputs(SearchBy::conceptName('cat'))
            ->executeSync();

        // The search is either successful or nothing has been found.
        $this->assertTrue($response->isSuccessful() || $response->status()->statusCode() == 40002);
    }

    public function testSearchInputsByImageURL()
    {
        $response = $this->client->searchInputs(SearchBy::imageURL(parent::CELEB_IMG_URL))
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->get()->searchHits());
    }

    public function testSearchInputsByURLImageVisually()
    {
        $response = $this->client->searchInputs(SearchBy::urlImageVisually(parent::CELEB_IMG_URL))
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->get()->searchHits());
    }

    public function testSearchInputsByURLImageVisuallyWithCrop()
    {
        $response = $this->client->searchInputs(SearchBy::urlImageVisually(parent::CELEB_IMG_URL,
                new Crop(0.1, 0.2, 0.3, 0.4)))
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->get()->searchHits());
    }

    public function testSearchInputsByFileImageVisually()
    {
        $base64 = file_get_contents(parent::BALLOONS_FILE_PATH);

        $response = $this->client->searchInputs(SearchBy::fileImageVisually($base64))
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->get()->searchHits());
    }

    public function testSearchInputsByGeoPointAndRadius()
    {
        $addInputsResponse = $this->client->addInputs((new ClarifaiURLImage(parent::CAT_IMG_URL))
                ->withAllowDuplicateUrl(true)
                ->withGeo(new GeoPoint(30, 40)))
            ->executeSync();
        $this->assertTrue($addInputsResponse->isSuccessful());

        try {
            $response = $this->client->searchInputs(SearchBy::geoCircle(new GeoPoint(31, 41),
                    new GeoRadius(1.5, GeoRadiusUnit::withinDegrees())))
                ->executeSync();

            $this->assertTrue($response->isSuccessful());
            $this->assertNotEquals(0, count($response->get()->searchHits()));
        } finally {
            $id = $addInputsResponse->get()[0]->id();
            $deleteInputsResponse = $this->client->deleteInputs($id)
                ->executeSync();
            $this->assertTrue($deleteInputsResponse->isSuccessful());
        }
    }

    public function testSearchInputsByTwoGeoPoints()
    {
        $addInputsResponse = $this->client->addInputs((new ClarifaiURLImage(parent::CAT_IMG_URL))
                ->withAllowDuplicateUrl(true)
                ->withGeo(new GeoPoint(30, 40)))
            ->executeSync();
        $this->assertTrue($addInputsResponse->isSuccessful());

        try {
            $response = $this->client->searchInputs(SearchBy::geoRectangle(new GeoPoint(29, 39),
                    new GeoPoint(31, 41)))
                ->executeSync();

            $this->assertTrue($response->isSuccessful());
            $this->assertNotEquals(0, count($response->get()->searchHits()));
        } finally {
            $id = $addInputsResponse->get()[0]->id();
            $deleteInputsResponse = $this->client->deleteInputs($id)
                ->executeSync();
            $this->assertTrue($deleteInputsResponse->isSuccessful());
        }
    }

    public function testSearchInputsByMetadata()
    {
        $randomVal = parent::generateRandomID();

        $addInputsResponse = $this->client->addInputs((new ClarifaiURLImage(parent::CAT_IMG_URL))
                ->withAllowDuplicateUrl(true)
                ->withMetadata(['key1' => 'val1', 'key2' => $randomVal]))
            ->executeSync();
        $this->assertTrue($addInputsResponse->isSuccessful());

        try {
            $response = $this->client->searchInputs(SearchBy::metadata(['key2' => $randomVal]))
                ->executeSync();

            $this->assertTrue($response->isSuccessful());

            /** @var SearchInputsResult $searchResult */
            $searchResult = $response->get();

            // Exactly one hit should have this exact key/value pair metadata.
            $this->assertEquals(1, count($searchResult->searchHits()));
        } finally {
            $id = $addInputsResponse->get()[0]->id();
            $deleteInputsResponse = $this->client->deleteInputs($id)
                ->executeSync();
            $this->assertTrue($deleteInputsResponse->isSuccessful());
        }
    }
}
