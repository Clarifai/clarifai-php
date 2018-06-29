<?php
namespace Clarifai\API;

class RequestMethod
{
    const GET = 0;
    const POST = 1;
    const PATCH = 2;
    const DELETE = 3;
}

interface ClarifaiHttpClientInterface
{
    public function getSync($url);
    public function postSync($url, $body);
    public function patchSync($url, $body);
    public function deleteSync($url, $body);
}
