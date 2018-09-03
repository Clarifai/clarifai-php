<?php

namespace Integration;

use Clarifai\DTOs\Crop;
use Clarifai\DTOs\GeoPoint;
use Clarifai\DTOs\Inputs\ClarifaiInput;
use Clarifai\DTOs\Inputs\ClarifaiInputsStatus;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Inputs\ModifyAction;
use Clarifai\DTOs\Predictions\Concept;

class InputIntTest extends BaseInt
{
    public function testAddGetAndDeleteInputs()
    {
        $inputID1 = $this->generateRandomID();
        $inputID2 = $this->generateRandomID();

        $geoPoint = new GeoPoint(55, 66);
        $crop = new Crop(0.1, 0.2, 0.3, 0.4);

        /*
         * Add the inputs.
         */
        $addResponse = $this->client->addInputs(
            [
                (new ClarifaiURLImage(parent::CAT_IMG_URL))
                    ->withID($inputID1)
                    ->withGeo($geoPoint)
                    ->withAllowDuplicateUrl(true),
                (new ClarifaiURLImage(parent::CELEB_IMG_URL))
                    ->withID($inputID2)
                    ->withCrop($crop)
                    ->withAllowDuplicateUrl(true)
            ])
            ->executeSync();
        $this->assertTrue($addResponse->isSuccessful());

        try {
            /*
             * Get inputs' status.
             */
            $inputsStatusResponse = $this->client->getInputsStatus()
                ->executeSync();
            $this->assertTrue($inputsStatusResponse->isSuccessful());

            /*
             * Get the inputs.
             */
            $getInputsResponse = $this->client->getInputs()
                ->executeSync();
            $this->assertTrue($getInputsResponse->isSuccessful());

            /*
             * Get input1.
             */
            $getInput1Response = $this->client->getInput($inputID1)
                ->executeSync();
            $this->assertTrue($getInput1Response->isSuccessful());
            $this->assertNotNull($getInput1Response->get()->createdAt());
            $this->assertEquals($geoPoint, $getInput1Response->get()->geo());

            /*
             * Get input2.
             */
            $getInput2Response = $this->client->getInput($inputID2)
                ->executeSync();
            $this->assertTrue($getInput2Response->isSuccessful());
            $this->assertNotNull($getInput2Response->get()->createdAt());
            $this->assertEquals($crop, $getInput2Response->get()->crop());

        } finally {
            /*
             * Delete the input.
             */
            $addResponse = $this->client->deleteInputs([$inputID1, $inputID2])
                ->executeSync();
            $this->assertTrue($addResponse->isSuccessful());
        }
    }

    public function testGetInputs()
    {
        $response = $this->client->getInputs()->executeSync();
        $this->assertTrue($response->isSuccessful());
    }

    public function testModifyInput()
    {
        $inputID = $this->generateRandomID();

        $addResponse = $this->client->addInputs(
            (new ClarifaiURLImage(parent::CAT_IMG_URL))
                ->withID($inputID)
                ->withAllowDuplicateUrl(true))
            ->executeSync();
        $this->assertTrue($addResponse->isSuccessful());

        try {
            $response = $this->client
                ->modifyInput($inputID, ModifyAction::overwrite())->withPositiveConcepts([
                    new Concept('concept1'), new Concept('concept2')
                ])
                ->executeSync();
            $this->assertTrue($response->isSuccessful());
        } finally {
            /*
             * Delete the input.
             */
            $response = $this->client->deleteInputs($inputID)
                ->executeSync();
            $this->assertTrue($response->isSuccessful());
        }
    }

    public function testModifyInputMetadata()
    {
        $inputID = $this->generateRandomID();

        $addResponse = $this->client->addInputs(
            (new ClarifaiURLImage(parent::CAT_IMG_URL))
                ->withID($inputID)
                ->withAllowDuplicateUrl(true)
                ->withMetadata(['key1' => 'val1', 'key2' => 'val2']))
            ->executeSync();
        $this->assertTrue($addResponse->isSuccessful());

        try {
            $response = $this->client
                ->modifyInput($inputID, ModifyAction::merge())->withMetadata(['key3' => 'val3'])
                ->executeSync();

            /** @var ClarifaiInput $input */
            $input = $response->get();
            $meta = $input->metadata();

            $this->assertEquals(3, count($meta));
            $this->assertEquals('val1', $meta['key1']);
            $this->assertEquals('val2', $meta['key2']);
            $this->assertEquals('val3', $meta['key3']);
        } finally {
            /*
             * Delete the input.
             */
            $response = $this->client->deleteInputs($inputID)
                ->executeSync();
            $this->assertTrue($response->isSuccessful());
        }
    }

    public function testDeleteAllInputs()
    {
        $deleteResponse = $this->client
            ->deleteInputs([], true)
            ->executeSync();
        $this->assertTrue($deleteResponse->isSuccessful());
    }
}
