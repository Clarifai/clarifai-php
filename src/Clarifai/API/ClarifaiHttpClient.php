<?php
namespace Clarifai\API;

class ClarifaiHttpClient implements ClarifaiHttpClientInterface
{
    private $apiKey;
    private $baseUrl;

    public function __construct($apiKey, $baseUrl = 'https://api.clarifai.com')
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
    }

    public function getSync($url)
    {
        $ch = $this->makeBaseCurl($url);
        return [curl_exec($ch), curl_getinfo($ch, CURLINFO_HTTP_CODE)];
    }

    public function postSync($url, $body)
    {
        $ch = $this->makeBaseCurl($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->serializeToJson($body));
        return [curl_exec($ch), curl_getinfo($ch, CURLINFO_HTTP_CODE)];
    }

    public function patchSync($url, $body)
    {
        $ch = $this->makeBaseCurl($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->serializeToJson($body));
        return [curl_exec($ch), curl_getinfo($ch, CURLINFO_HTTP_CODE)];
    }

    public function deleteSync($url, $body)
    {
        $ch = $this->makeBaseCurl($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->serializeToJson($body));
        return [curl_exec($ch), curl_getinfo($ch, CURLINFO_HTTP_CODE)];
    }

    private function makeBaseCurl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . '/' . $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Key $this->apiKey",
            'Content-Type: application/json',
        ));
        return $ch;
    }

    private function serializeToJson($body)
    {
        if (count($body) == 0) {
            return json_encode($body, JSON_FORCE_OBJECT);
        }
        return json_encode($body);
    }
}
