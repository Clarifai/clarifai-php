<?php
namespace Clarifai\API\Requests;

use Clarifai\API\ClarifaiHttpClientInterface;
use Clarifai\API\ClarifaiResponse;
use Clarifai\API\RequestMethod;
use Clarifai\DTOs\ClarifaiStatus;
use Clarifai\DTOs\StatusType;
use Clarifai\Exceptions\ClarifaiException;

abstract class ClarifaiJsonRequest
{
    /**
     * @var ClarifaiHttpClientInterface The Clarifai HTTP client.
     */
    protected $httpClient;

    protected function __construct(ClarifaiHttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    protected abstract function requestMethod();
    protected abstract function url();

    public function executeSync() {

        try {
            list($rawBody, $httpStatusCode) = $this->httpRequest();
        } catch (\Exception $e) {
            return new ClarifaiResponse(
                new ClarifaiStatus(StatusType::networkError(), 404, 'HTTP request failed.',
                    $e->getMessage()),
                '',
                []);  # TODO (Rok) HIGH: What should be returned here?
        }

        $jsonObject = json_decode($rawBody, true);

        if (is_null($jsonObject)) {
            return new ClarifaiResponse(
                new ClarifaiStatus(StatusType::networkError(), $httpStatusCode,
                    'Server provided a malformed JSON response.', json_last_error_msg()),
                $rawBody,
                []);  # TODO (Rok) HIGH: What should be returned here?
        }

        if (array_key_exists('status', $jsonObject)) {
            $status = ClarifaiStatus::deserializeJson($jsonObject['status'], $httpStatusCode);
        } else {
            // If no status object is present, assume it's positive.
            $status = new ClarifaiStatus(StatusType::successful(), -1, '', null);
        }

        $statusType = $status->type();
        if ($statusType == StatusType::successful() || $statusType == StatusType::mixedSuccess()) {

            $deserialized = $this->unmarshaller($jsonObject);
            return new ClarifaiResponse($status, $rawBody, $deserialized);
        } else {
            try {
                $deserialized = $this->unmarshaller($jsonObject);
            } catch (\Exception $e) {
                $deserialized = [];
            }
            return new ClarifaiResponse($status, $rawBody, $deserialized);
        }
    }

    private function httpRequest()
    {
        $method = $this->requestMethod();
        switch ($method)
        {
            case RequestMethod::GET:
            {
                return $this->httpClient->getSync($this->url());
            }
            case RequestMethod::POST:
            {
                return $this->httpClient->postSync($this->url(),
                    $this->httpRequestBody());
            }
            case RequestMethod::PATCH:
            {
                return $this->httpClient->patchSync($this->url(),
                    $this->httpRequestBody());
            }
            case RequestMethod::DELETE:
            {
                return $this->httpClient->deleteSync($this->url(),
                    $this->httpRequestBody());
            }
            default:
            {
                return new ClarifaiException("Unknown requestMethod $method.");
            }
        }
    }

    /**
     * @return string The complete URL to run the request against, including any additional info.
     *                Must not include base.
     */
    protected function buildUrl()
    {
        return $this->url();
    }

    protected abstract function httpRequestBody();
    protected abstract function unmarshaller($jsonObject);
}
