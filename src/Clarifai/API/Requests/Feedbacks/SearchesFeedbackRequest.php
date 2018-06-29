<?php

namespace Clarifai\API\Requests\Feedbacks;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\CustomV2Client;
use Clarifai\API\RequestMethod;
use Clarifai\API\Requests\ClarifaiRequest;
use Clarifai\Grpc\EventType;
use Clarifai\Grpc\FeedbackInfo;
use Clarifai\Grpc\Input;
use Clarifai\Grpc\PostSearchFeedbackRequest;
use Clarifai\Grpc\Status\BaseResponse;

/**
 * This request is meant to collect the correctly searched inputs, which is usually done by
 * capturing your end user's clicks on the given search results. Your feedback will help us
 * improve our search algorithm.
 */
class SearchesFeedbackRequest extends ClarifaiRequest
{
    /**
     * @var string
     */
    private $inputID;
    /**
     * @var string
     */
    private $searchID;
    /**
     * @var string
     */
    private $endUserID;
    /**
     * @var string
     */
    private $sessionID;

    /**
     * Ctor.
     * @param ClarifaiClientInterface $client The Clarifai client.
     * @param string $inputID The input ID of a correct image (hit).
     * @param string $searchID ID of the search from SearchInputsRequest.
     * @param string $endUserID The ID associated with your end user.
     * @param string $sessionID The ID associated with your user's interface.
     */
    public function __construct(ClarifaiClientInterface $client, $inputID, $searchID, $endUserID,
        $sessionID)
    {
        parent::__construct($client);
        $this->inputID = $inputID;
        $this->searchID = $searchID;
        $this->endUserID = $endUserID;
        $this->sessionID = $sessionID;
    }

    protected function requestMethod()
    {
        return RequestMethod::POST;
    }

    protected function url()
    {
        return '/v2/searches/feedback';
    }

    protected function httpRequestBody(CustomV2Client $grpcClient)
    {
        return $grpcClient->PostSearchFeedback((new PostSearchFeedbackRequest())
            ->setInput((new Input())
                ->setId($this->inputID)
                ->setFeedbackInfo((new FeedbackInfo())
                    ->setEventType(EventType::search_click)
                    ->setSearchId($this->searchID)->setEndUserId($this->endUserID)
                    ->setSessionId($this->sessionID))));
    }

    /**
     * @param BaseResponse $response
     * @return void
     */
    protected function unmarshaller($response)
    {
        return;
    }
}
