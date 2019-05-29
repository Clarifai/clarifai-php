<?php

namespace Clarifai\API;

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
