<?php

namespace Clarifai\API;

use Clarifai\Exceptions\ClarifaiException;
use function Google\Protobuf\Internal\camel2underscore;

class CustomV2Client extends \Clarifai\Internal\V2Client
{
    private $url;
    private $requestMethod;
    private $httpClient;

    /**
     * Ctor.
     * @param string $url
     * @param int $requestMethod
     * @param ClarifaiHttpClientInterface $httpClient
     */
    public function __construct($url, $requestMethod, $httpClient) {
        $this->url = $url;
        $this->requestMethod = $requestMethod;
        $this->httpClient = $httpClient;
    }

    protected function _simpleRequest($method,
        $argument,
        $deserialize,
        array $metadata = [],
        array $options = [])
    {
        $jsonBody = null;
        if ($this->requestMethod != RequestMethod::GET) {
            $grpcSerializedJson = $argument->serializeToJsonString();
            $jsonBody = json_decode($grpcSerializedJson, true);
            $this->_trimmer($jsonBody);
        }

        return new CustomGrpcRequest($this->url, $this->requestMethod, $jsonBody, $deserialize,
            $this->httpClient);
    }

    function _isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    function _trimmer(&$var) {
        if (is_array($var)) {
            foreach($var as &$v) {
                $this->_trimmer($v);
            }
            // only additional code
            $keys = [];
            foreach ($var as $k => $vals) {
                // Convert camel cased keys back to snake cased.
                $snake_case_key = camel2underscore($k);
                array_push($keys, $snake_case_key);

                if ($snake_case_key == 'concepts') {
                    foreach ($vals as $i => $c) {
                        if (key_exists('value', $c) && $c['value'] == -1.0) {
                            $c['value'] = 0.0;
                        }
                        $vals[$i] = $c;
                    }
                }
                $var[$k] = $vals;
            }
            if ($this->_isAssoc($var)) {
                $var = array_combine($keys, $var);
            }
        }
    }

}

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

