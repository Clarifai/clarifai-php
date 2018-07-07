<?php

namespace Integration;

use Clarifai\DTOs\Predictions\Concept;

class ConceptIntTest extends BaseInt
{
    public function testGetConcept()
    {
        // This call won't be successful if the "dog" concepts has already been added,
        // but that's fine in this case.
        $this->client->addConcepts(new Concept("dog"))->executeSync();

        $response = $this->client->getConcept("dog")->executeSync();
        $this->assertTrue($response->isSuccessful());

        $concept = $response->get();
        $this->assertEquals("dog", $concept->id());
    }

    public function testGetConcepts()
    {
        $response = $this->client->getConcepts()->executeSync();
        $this->assertTrue($response->isSuccessful());

        $concepts = $response->get();
        $this->assertNotNull($concepts);
    }

    public function testModifyConcepts()
    {
        // This call won't be successful if the "dog" concepts has already been added,
        // but that's fine in this case.
        $this->client->addConcepts([new Concept("dog")])->executeSync();

        $response = $this->client->modifyConcepts((new Concept("dog"))->withName("new-dog-name"))
            ->executeSync();
        $this->assertTrue($response->isSuccessful());

        $concepts = $response->get();
        $this->assertEquals("new-dog-name", $concepts[0]->name());
    }

    public function testSearchConcepts()
    {
        $response = $this->client->searchConcepts('conc*')
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->get());
    }

    public function testSearchConceptsWithLanguage()
    {
        $response = $this->client->searchConcepts('狗*')
            ->withLanguage('zh')
            ->executeSync();
        $this->assertTrue($response->isSuccessful());
        $this->assertNotNull($response->get());
    }
}
