<?php

namespace Integration;

use Clarifai\DTOs\Crop;
use Clarifai\DTOs\Feedbacks\ConceptFeedback;
use Clarifai\DTOs\Feedbacks\Feedback;
use Clarifai\DTOs\Feedbacks\RegionFeedback;

class FeedbackIntTest extends BaseInt
{

    public function testModelFeedback()
    {
        $response = $this->client->modelFeedback(
                $this->client->publicModels()->generalModel()->modelID(),
                parent::CAT_IMG_URL,
                '@inputID',
                '@outputID',
                '@endUserID',
                '@sessionID')
            ->withConceptFeedbacks([
                new ConceptFeedback('cat', true),
                new ConceptFeedback('dog', false)]
            )
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
    }

    public function testModelFeedbackWithRegions()
    {
        $response = $this->client->modelFeedback(
            $this->client->publicModels()->celebrityModel()->modelID(),
            parent::CELEB_IMG_URL,
            '@inputID',
            '@outputID',
            '@endUserID',
            '@sessionID')
            ->withConceptFeedbacks([
                new ConceptFeedback('freeman', true),
                new ConceptFeedback('eminem', false)
            ])
            ->withRegionFeedbacks([(new RegionFeedback())
                ->withCrop(new Crop(0.1, 0.2, 0.3, 0.4))
                ->withFeedback(Feedback::notDetected())->withConceptFeedbacks([
                    new ConceptFeedback('freeman', true) ,
                    new ConceptFeedback('eminem', true)
                ])])
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
    }

    public function testSearchesFeedback()
    {
        $response = $this->client->searchesFeedback("@inputID", "@searchID", "@endUserID",
                "@sessionID")
            ->executeSync();

        $this->assertTrue($response->isSuccessful());
    }
}
