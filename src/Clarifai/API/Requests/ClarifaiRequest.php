<?php
namespace Clarifai\API\Requests;

use Clarifai\API\ClarifaiClientInterface;
use Clarifai\API\ClarifaiResponse;
use Clarifai\API\CustomV2Client;
use Clarifai\DTOs\ClarifaiStatus;
use Clarifai\DTOs\StatusType;

abstract class ClarifaiRequest
{
    /**
     * @var ClarifaiClientInterface the Clarifai client
     */
    protected $client;

    protected function __construct(ClarifaiClientInterface $client)
    {
        $this->client = $client;
    }

    protected abstract function requestMethod();
    protected abstract function url();

    public function executeSync()
    {
        $request = $this->httpRequest();
        try {
            list($response, $rawBody, $httpStatusCode) = $request->wait();
        } catch (\Throwable $e) {
            return new ClarifaiResponse(
                new ClarifaiStatus(StatusType::networkError(), 404, 'HTTP request failed.',
                    $e->getMessage()),
                '',
                []);  # TODO (Rok) HIGH: What should be returned here?
        }
        $status = ClarifaiStatus::deserialize($response->getStatus(), $httpStatusCode);
        $statusType = $status->type();
        if ($statusType == StatusType::successful() || $statusType == StatusType::mixedSuccess()) {
            $deserialized = $this->unmarshaller($response);
            return new ClarifaiResponse($status, $rawBody, $deserialized);
        } else {
            try {
                $deserialized = $this->unmarshaller($response);
            } catch (\Throwable $e) {
                $deserialized = [];
            }
            return new ClarifaiResponse($status, $rawBody, $deserialized);
        }
    }

    private function httpRequest()
    {
        return $this->httpRequestBody(new CustomV2Client(
            $this->buildUrl(), $this->requestMethod(), $this->client->httpClient()));
    }

    /**
     * @return string The complete URL to run the request against, including any additional info.
     *                Must not include base.
     */
    protected function buildUrl()
    {
        return $this->url();
    }

    protected abstract function httpRequestBody(CustomV2Client $grpcClient);
    protected abstract function unmarshaller($response);
}
