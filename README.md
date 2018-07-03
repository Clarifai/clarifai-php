![Clarifai logo](docs/logo.png)

# Clarifai API PHP Client

- Try the Clarifai demo at: https://clarifai.com/demo
- Sign up for a free account at: https://clarifai.com/developer/signup/
- Read the developer guide at: https://clarifai.com/developer/guide/


[![Latest Stable Version](https://poser.pugx.org/clarifai/clarifai-php/version)](https://packagist.org/packages/clarifai/clarifai-php)
[![License](https://poser.pugx.org/clarifai/clarifai-php/license)](https://github.com/Clarifai/clarifai-php/blob/master/LICENSE)


## Installation

`composer require clarifai/clarifai-php`

> Note: If you're not using a framework (e.g Laravel), you may need to require the `autoload.php`
file produced by composer: `require_once('vendor/autoload.php');`

###  Prerequisites

PHP >=7.0

## Getting Started

### Predicting what concepts are contained within an image
```php
use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Outputs\ClarifaiOutput;
use Clarifai\DTOs\Predictions\Concept;

// Skip the argument to fetch the key from the CLARIFAI_API_KEY env. variable
$client = new ClarifaiClient('YOUR_API_KEY');

$response = $client->publicModels()->generalModel()->predict(
        new ClarifaiURLImage('https://samples.clarifai.com/metro-north.jpg'))
    ->executeSync();

if ($response->isSuccessful()) {
    echo "Response is successful.\n";

    /** @var ClarifaiOutput $output */
    $output = $response->get();

    echo "Predicted concepts:\n";
    /** @var Concept $concept */
    foreach ($output->data() as $concept) {
        echo $concept->name() . ': ' . $concept->value() . "\n";
    }
} else {
    echo "Response is not successful. Reason: \n";
    echo $response->status()->description() . "\n";
    echo $response->status()->errorDetails() . "\n";
    echo "Status code: " . $response->status()->statusCode();
}
```

### Searching for other visually similar images
```php
use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Searches\SearchBy;
use Clarifai\DTOs\Searches\SearchInputsResult;

$client = new ClarifaiClient('YOUR_API_KEY');

$response = $client->searchInputs(
        SearchBy::urlImageVisually('https://samples.clarifai.com/metro-north.jpg'))
    ->executeSync();

if ($response->isSuccessful()) {
    echo "Response is successful.\n";

    /** @var SearchInputsResult $result */
    $result = $response->get();

    foreach ($result->searchHits() as $searchHit) {
        echo $searchHit->input()->id() . ' ' . $searchHit->score() . "\n";
    }
} else {
    echo "Response is not successful. Reason: \n";
    echo $response->status()->description() . "\n";
    echo $response->status()->errorDetails() . "\n";
    echo "Status code: " . $response->status()->statusCode();
}
```

### Creating and training a custom model on some inputs and concepts
```php
use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Models\ModelType;
use Clarifai\DTOs\Predictions\Concept;

$client = new ClarifaiClient('YOUR_API_KEY');

$client->addConcepts('boscoe')
    ->executeSync();

$client->addInputs([
    (new ClarifaiURLImage('https://samples.clarifai.com/puppy.jpeg'))
        ->withPositiveConcepts([new Concept('boscoe')]),
    (new ClarifaiURLImage('https://samples.clarifai.com/wedding.jpg'))
        ->withNegativeConcepts([new Concept('boscoe')])
])
    ->executeSync();

$client->createModel('pets')
    ->withConcepts([new Concept('boscoe')])
    ->executeSync();

$response = $client->trainModel(ModelType::concept(), 'pets')
    ->executeSync();

if ($response->isSuccessful()) {
    echo "Response is successful.\n";
} else {
    echo "Response is not successful. Reason: \n";
    echo $response->status()->description() . "\n";
    echo $response->status()->errorDetails() . "\n";
    echo "Status code: " . $response->status()->statusCode();
}
```

This model can now be used to predict concepts on other new inputs.

## Getting Help

If you need any help with using the library, please contact Support at support@clarifai.com or our
Developer Relations team at developers@clarifai.com.

If you've found a bug or would like to make a feature request, please make an issue or a pull
request here.


## License

This project is licensed under the Apache 2.0 License - see the [LICENSE](LICENSE) file for details.
