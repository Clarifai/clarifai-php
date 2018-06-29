# Clarifai API PHP Client

- Try the Clarifai demo at: https://clarifai.com/demo
- Sign up for a free account at: https://clarifai.com/developer/signup/
- Read the developer guide at: https://clarifai.com/developer/guide/


## Installation

`composer require clarifai/clarifai-php`

###  Prerequisites

PHP >=7.0

## Getting Started

```php
$client = new ClarifaiClient('YOUR_CLARIFAI_API_KEY');  // Skip the argument to fetch it from the CLARIFAI_API_KEY env. variable

$response = $this->client->publicModels()->moderationModel()
    ->predict(new ClarifaiURLImage('IMAGE_URL'))
    ->executeSync();
```


## License

This project is licensed under the Apache 2.0 License - see the [LICENSE](LICENSE) file for details.
