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

> Note: This library requires the *curl* PHP extension to be enabled. This is most likely already
done on your PHP host service, unless you're hosting PHP yourself, in which case you may need to 
uncomment (delete `;`) the line `extension=php_curl.dll` in your `php.ini` file.

## Getting Started

We're going to show three common examples of using the Clarifai API. Below are all the imports
needed to run these examples. In addition, the `ClarifaiClient` object is created which is used to
access all the available methods in the Clarifai API.

```php
use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Outputs\ClarifaiOutput;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\DTOs\Searches\SearchBy;
use Clarifai\DTOs\Searches\SearchInputsResult;
use Clarifai\DTOs\Models\ModelType;

// Skip the argument to fetch the key from the CLARIFAI_API_KEY env. variable
$client = new ClarifaiClient('YOUR_API_KEY');
```

> Note: Rather than hard-coding your Clarifai API key, a better practice is to save the key in an
environmental variable. If you skip the argument and do simply `new ClarifaiClient()`, the client
will automatically try to read your API key from an environmental variable called `CLARIFAI_API_KEY`
which you should set in your environment.

### Example #1: Prediction

The following code will recognise concepts that are contained within each of the images in a list.
It uses our general public model that recognizes a wide variety of concepts.

```php
$model = $client->publicModels()->generalModel();
$response = $model->batchPredict([
    new ClarifaiURLImage('https://samples.clarifai.com/metro-north.jpg'),
    new ClarifaiURLImage('https://samples.clarifai.com/wedding.jpg'),
])->executeSync();
```

If your use-case requires more specific predictions, you can use one of the more specialized public
models such as the `weddingModel`, `foodModel`, `nfswModel` etc.
[Here](https://clarifai.com/models/) is a list of all the available models.

> Note: You can also create your own models and train them on your own image dataset. We show how
to do that in Example #2. Besides running the prediction on an URL image using
`new ClarifaiURLImage`, you can also predict on a local file image by using `new ClarifaiFileImage`.

See below how to access the data from the `$response` variable. For each image, we print out
all the concepts that were predicted by the model for that image.

```php
/** @var ClarifaiOutput[] $outputs */
$outputs = $response->get();

foreach ($outputs as $output) {
    /** @var ClarifaiURLImage $image */
    $image = $output->input();
    echo "Predicted concepts for image at url " . $image->url() . "\n";
    
    /** @var Concept $concept */
    foreach ($output->data() as $concept) {
        echo $concept->name() . ': ' . $concept->value() . "\n";
    }
    echo "\n";
}
```

> Note: The value stored in `$concept->value()` is the precentage likelihood that the concept by
the name of `$concept->name()` is contained within an image.

When something goes wrong, you can handle the error and inspect the details. In your program, this
code below would go above the previous section of code.

```php
if (!$response->isSuccessful()) {
    echo "Response is not successful. Reason: \n";
    echo $response->status()->description() . "\n";
    echo $response->status()->errorDetails() . "\n";
    echo "Status code: " . $response->status()->statusCode();
    exit(1);
}
```

See [the Clarifai Developer Guide](https://clarifai.com/developer/guide/) on how to do predict
concepts in videos.

### Example #2: Custom model Creating and training a custom model on some inputs and concepts

You can create your own model, add training data, and use the model to perform predictions on
new images in the same way as in Example #1.

This is done by first creating concepts are the subject of our model. Sample inputs are then
added which we associate or disassociate with certain concepts. After the model is created, we train
the model, after which the model is available to performing predictions on new inputs.

```php
$client->addConcepts([new Concept('boscoe')])
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

### Example #3: Visual search

An image can be used in a search to find other visually-similar images. After adding some images
using `addInputs` (see Example #2), we use `searchInputs` to perform the search.


```php
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

Please see [the Clarifai Developer Guide](https://clarifai.com/developer/guide/) to find out more
of what the Clarifai API can give you.

## Getting Help

If you need any help with using the library, please contact Support at support@clarifai.com or our
Developer Relations team at developers@clarifai.com.

If you've found a bug or would like to make a feature request, please make an issue or a pull
request here.


## License

This project is licensed under the Apache 2.0 License - see the [LICENSE](LICENSE) file for details.
