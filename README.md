# Clarifai API PHP Client

- Try the Clarifai demo at: https://clarifai.com/demo
- Sign up for a free account at: https://clarifai.com/developer/signup/
- Read the developer guide at: https://clarifai.com/developer/guide/


## Installation

`composer require clarifai/clarifai-php`

> Note: If you're not using a framework (e.g Laravel), you may need to require the `autoload.php`
file produced by composer: `require_once('vendor/autoload.php');`

###  Prerequisites

PHP >=7.0

## Getting Started

```php
$client = new ClarifaiClient('YOUR_CLARIFAI_API_KEY');  // Skip the argument to fetch it from the CLARIFAI_API_KEY env. variable

$response = $this->client->publicModels()->moderationModel()
    ->predict(new ClarifaiURLImage('IMAGE_URL'))
    ->executeSync();
```


## Getting Help

If you need any help with using the library, please contact Support at support@clarifai.com or our
Developer Relations team at developers@clarifai.com.

If you've found a bug or would like to make a feature request, please make an issue or a pull
request here.


## License

This project is licensed under the Apache 2.0 License - see the [LICENSE](LICENSE) file for details.
