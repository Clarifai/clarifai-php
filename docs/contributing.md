## Contributing

1. Fork & clone this repo.
1. Make the changes.
1. Make sure all the tests (or at least unit tests) pass.

## Building

`docker build . -t clarifai-php`

### Running Unit Tests

`docker run -ti clarifai-php phpunit -c phpunit.xml --filter UnitTest`

### Running Integration Tests

To successfully run integration tests, you have to have a valid Clarifai API key with all required permissions.

Create a new API key at the [API keys page](https://www.clarifai.com/developer/account/api-keys) and set it as an environmental variable `CLARIFAI_API_KEY`.

> Warning: The requests made by integration tests are run against the production system and will use your operations.


1. Set your Clarifai API key: `export CLARIFAI_API_KEY=your_clarifai_api_key`

1. `docker run -ti -e CLARIFAI_API_KEY=$CLARIFAI_API_KEY clarifai-php phpunit -c phpunit.xml --filter
IntTest`
