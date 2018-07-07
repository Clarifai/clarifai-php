<?php

namespace Unit;

use Clarifai\API\ClarifaiHttpClientInterface;

/**
 * A fake Clarifai HTTP client used for testing.
 */
// TODO (Rok) HIGH: Figure out how to load this class and not have the name ending with Test.
class FkClarifaiHttpClientTest implements ClarifaiHttpClientInterface
{
    private $getResponse;
    private $postResponse;
    private $patchResponse;
    private $deleteResponse;

    private $postedBody;
    /**
     * @return array The body of the last POST request.
     */
    public function postedBody() { return $this->postedBody; }

    private $patchedBody;
    /**
     * @return array The body of the last PATCH request.
     */
    public function patchedBody() { return $this->patchedBody; }

    private $deletedBody;
    /**
     * @return array The body of the last DELETE request.
     */
    public function deletedBody() { return $this->deletedBody; }

    /**
     * Ctor.
     * @param string $getResponse The response GET request should return.
     * @param string $postResponse The response POST request should return.
     * @param string $patchResponse The response PATCH request should return.
     * @param string $deleteResponse The response DELETE request should return.
     */
    public function __construct($getResponse = null, $postResponse = null, $patchResponse = null,
        $deleteResponse = null)
    {
        $this->getResponse = $getResponse;
        $this->postResponse = $postResponse;
        $this->patchResponse = $patchResponse;
        $this->deleteResponse = $deleteResponse;
    }

    public function getSync($url)
    {
        return [$this->getResponse, 200];
    }

    public function postSync($url, $body)
    {
        $this->postedBody = $body;
        return [$this->postResponse, 200];
    }

    public function patchSync($url, $body)
    {
        $this->patchedBody = $body;
        return [$this->patchResponse, 200];
    }

    public function deleteSync($url, $body)
    {
        $this->deletedBody = $body;
        return [$this->deleteResponse, 200];
    }
}