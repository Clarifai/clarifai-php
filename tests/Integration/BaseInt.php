<?php

namespace Integration;

use Clarifai\API\ClarifaiHttpClient;
use PHPUnit\Framework\TestCase;

use Clarifai\API\ClarifaiClient;

class BaseInt extends TestCase
{
    const CELEB_IMG_URL =
        'https://clarifai.com/developer/static/images/model-samples/celeb-001.jpg';
    const FOCUS_IMG_URL =
        'https://clarifai.com/developer/static/images/model-samples/focus-001.jpg';
    const CAT_IMG_URL = 'https://clarifai.com/developer/static/images/model-samples/focus-001.jpg';
    const GIF_VIDEO_URL = 'https://s3.amazonaws.com/samples.clarifai.com/D7qTae7IQLKSI.gif';

    const BALLOONS_FILE_PATH = 'tests/Integration/Assets/balloons.jpg';
    const BEER_VIDEO_FILE_PATH = 'tests/Integration/Assets/beer.mp4';

    protected $client;

    public function __construct()
    {
        parent::__construct();
        $apiKey = getenv('CLARIFAI_API_KEY');
        $baseUrl = getenv('CLARIFAI_API_BASE');
        if (!$baseUrl) {
            $baseUrl = "https://api.clarifai.com";
        }
        $this->client = new ClarifaiClient($apiKey, new ClarifaiHttpClient($apiKey, $baseUrl));
    }

    /**
     * @return string A random ID.
     */
    public function generateRandomID()
    {
        return substr(str_shuffle(MD5(microtime())), 0, 10);
    }
}
