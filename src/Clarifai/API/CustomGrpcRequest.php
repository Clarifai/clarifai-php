<?php

namespace Clarifai\API;

use Clarifai\Exceptions\ClarifaiException;

class CustomGrpcRequest {

    private $ch;
    /**
     * @var string
     */
    private $url;
    /**
     * @var int
     */
    private $requestMethod;
    /**
     * @var string
     */
    private $jsonBody;
    /**
     * @var callable
     */
    private $deserialize;
    /**
     * @var ClarifaiHttpClientInterface
     */
    private $httpClient;

    /**
     * Ctor.
     * @param string $url
     * @param int $requestMethod
     * @param string $jsonBody
     * @param callable $deserialize
     * @param ClarifaiHttpClientInterface $httpClient
     */
    public function __construct($url, $requestMethod, $jsonBody, $deserialize, $httpClient)
    {
        $this->url = $url;
        $this->requestMethod = $requestMethod;
        $this->jsonBody = $jsonBody;
        $this->deserialize = $deserialize;
        $this->httpClient = $httpClient;
    }

    public function wait()
    {
        switch ($this->requestMethod) {
            case RequestMethod::GET: {
                list($rawBody, $httpStatusCode) = $this->httpClient->getSync($this->url);
                break;
            }
            case RequestMethod::POST: {
                list($rawBody, $httpStatusCode) = $this->httpClient->postSync($this->url,
                    $this->jsonBody);
                break;
            }
            case RequestMethod::PATCH: {
                list($rawBody, $httpStatusCode) = $this->httpClient->patchSync($this->url,
                    $this->jsonBody);
                break;
            }
            case RequestMethod::DELETE: {
                list($rawBody, $httpStatusCode) = $this->httpClient->deleteSync($this->url,
                    $this->jsonBody);
                break;
            }
            default: {
                throw new ClarifaiException('Unknown RequestMethod: ' . $this->requestMethod);
            }
        }

        return [$this->_deserializeResponse($rawBody), $rawBody, $httpStatusCode];
    }

    protected function _deserializeResponse($rawBody)
    {
        if ($rawBody === null) {
            throw new \Exception("Trying to deserialize null.");
        }

        // Proto3 implementation
        if (is_array($this->deserialize)) {
            list($className, $deserializeFunc) = $this->deserialize;
            $obj = new $className();
            if (method_exists($obj, $deserializeFunc)) {
                $obj->$deserializeFunc($rawBody);
            } else {
                $obj->mergeFromJsonString($rawBody);
            }

            return $obj;
        }

        // Protobuf-PHP implementation
        return call_user_func($this->deserialize, $rawBody);
    }
}
