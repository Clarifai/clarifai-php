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

## Development

1. Fork & clone this repo.
1. Make the changes.
1. Make sure all the tests pass.

## Tests

`docker build . -t clarifai-php`

### Unit Tests

`docker run -ti clarifai-php phpunit -c phpunit.xml --filter UnitTest`

### Integration Tests


To successfully run integration tests, you have to have a valid Clarifai API key with all required permissions.

Create a new API key at the [API keys page](https://www.clarifai.com/developer/account/api-keys) and set it as an environmental variable `CLARIFAI_API_KEY`.

> Warning: The requests made by integration tests are run against the production system and will use your operations.


1. Set your Clarifai API key: `export CLARIFAI_API_KEY=your_clarifai_api_key`

1. `docker run -ti -e CLARIFAI_API_KEY=$CLARIFAI_API_KEY clarifai-php phpunit -c phpunit.xml --filter
IntTest`

## License

This project is licensed under the Apache 2.0 License - see the [LICENSE](LICENSE) file for details.
