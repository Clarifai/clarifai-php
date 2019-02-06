<?php

namespace Unit;

use Clarifai\DTOs\Crop;
use Clarifai\DTOs\Models\ColorModel;
use Clarifai\DTOs\Models\DemographicsModel;
use Clarifai\DTOs\Models\EmbeddingModel;
use Clarifai\DTOs\Models\FaceConceptsModel;
use Clarifai\DTOs\Models\FaceDetectionModel;
use Clarifai\DTOs\Models\FaceEmbeddingModel;
use Clarifai\DTOs\Models\FocusModel;
use Clarifai\DTOs\Models\LogoModel;
use Clarifai\DTOs\Models\OutputInfos\DemographicsOutputInfo;
use Clarifai\DTOs\Models\OutputInfos\EmbeddingOutputInfo;
use Clarifai\DTOs\Models\VideoModel;
use Clarifai\DTOs\Outputs\ClarifaiOutput;
use Clarifai\DTOs\Predictions\Color;
use Clarifai\DTOs\Predictions\Concept;
use Clarifai\DTOs\Predictions\Demographics;
use Clarifai\DTOs\Predictions\Embedding;
use Clarifai\DTOs\Predictions\FaceConcepts;
use Clarifai\DTOs\Predictions\FaceDetection;
use Clarifai\DTOs\Predictions\FaceEmbedding;
use Clarifai\DTOs\Predictions\Focus;
use Clarifai\DTOs\Predictions\Frame;
use Clarifai\DTOs\Predictions\Logo;
use PHPUnit\Framework\TestCase;

use Clarifai\API\ClarifaiClient;
use Clarifai\DTOs\Inputs\ClarifaiURLImage;
use Clarifai\DTOs\Models\ModelType;

class VariousModelsUnitTest extends TestCase
{
    public function testColorGetModel()
    {
        $getResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "model": {
    "id": "@modelID",
    "name": "color",
    "created_at": "2016-05-11T18:05:45.924367Z",
    "app_id": "main",
    "output_info": {
      "data": {
        "concepts": [
          {
            "id": "@conceptID1",
            "name": "AliceBlue",
            "value": 1,
            "created_at": "2017-06-15T20:40:52.248062Z",
            "language": "en",
            "app_id": "main"
          },
          {
            "id": "@conceptID2",
            "name": "AntiqueWhite",
            "value": 1,
            "created_at": "2017-06-15T20:40:52.248062Z",
            "language": "en",
            "app_id": "main"
          }
        ]
      },
      "type": "color",
      "type_ext": "color"
    },
    "model_version": {
      "id": "@modelVersionID",
      "created_at": "2016-07-13T01:19:12.147644Z",
      "status": {
        "code": 21100,
        "description": "Model trained successfully"
      },
      "active_concept_count": 140,
      "train_stats": {}
    },
    "display_name": "Color"
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getModel(ModelType::color(), '@modelID')->executeSync();
        $this->assertTrue($response->isSuccessful());

        /** @var ColorModel $model */
        $model = $response->get();
        $this->assertEquals('@modelID', $model->modelID());
        $this->assertEquals('color', $model->name());
        $this->assertEquals('@modelVersionID', $model->modelVersion()->id());

        $concepts = $model->outputInfo()->concepts();

        $this->assertEquals('@conceptID1', $concepts[0]->id());
        $this->assertEquals('AliceBlue', $concepts[0]->name());

        $this->assertEquals('@conceptID2', $concepts[1]->id());
        $this->assertEquals('AntiqueWhite', $concepts[1]->name());
    }

    public function testColorPredict()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "outputs": [
    {
      "id": "@outputID",
      "status": {
        "code": 10000,
        "description": "Ok"
      },
      "created_at": "2019-01-30T10:17:40.806851955Z",
      "model": {
        "id": "@modelID",
        "name": "color",
        "created_at": "2016-05-11T18:05:45.924367Z",
        "app_id": "main",
        "output_info": {
          "message": "Show output_info with: GET /models/{model_id}/output_info",
          "type": "color",
          "type_ext": "color"
        },
        "model_version": {
          "id": "@modelVersionID",
          "created_at": "2016-07-13T01:19:12.147644Z",
          "status": {
            "code": 21100,
            "description": "Model trained successfully"
          },
          "train_stats": {}
        },
        "display_name": "Color"
      },
      "input": {
        "id": "@inputID",
        "data": {
          "image": {
            "url": "@url"
          }
        }
      },
      "data": {
        "colors": [
          {
            "raw_hex": "#f2f2f2",
            "w3c": {
              "hex": "#f5f5f5",
              "name": "WhiteSmoke"
            },
            "value": 0.929
          },
          {
            "raw_hex": "#686078",
            "w3c": {
              "hex": "#708090",
              "name": "SlateGray"
            },
            "value": 0.02675
          }
        ]
      }
    }
  ]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->predict(ModelType::color(), "", new ClarifaiURLImage("@url"))
            ->executeSync();

        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "data": {
        "image": {
          "url": "@url"
        }
      }
    }
  ]
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());

        /** @var ClarifaiOutput $output */
        $output = $response->get();

        $this->assertEquals('@inputID', $output->input()->id());
        $this->assertEquals('@outputID', $output->id());

        /** @var Color[] $colors */
        $colors = $output->data();

        $this->assertEquals("WhiteSmoke", $colors[0]->name());
        $this->assertEquals("#f2f2f2", $colors[0]->rawHex());
        $this->assertEquals("#f5f5f5", $colors[0]->hex());
        $this->assertEquals(0.929, $colors[0]->value());

        $this->assertEquals("SlateGray", $colors[1]->name());
        $this->assertEquals("#686078", $colors[1]->rawHex());
        $this->assertEquals("#708090", $colors[1]->hex());
        $this->assertEquals(0.02675, $colors[1]->value());
    }

    public function testDemographicsGetModel()
    {
        $getResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "model": {
    "id": "@modelID",
    "name": "demographics",
    "created_at": "2016-12-23T06:08:44.271674Z",
    "app_id": "main",
    "output_info": {
      "data": {
        "concepts": [
          {
            "id": "@conceptID1",
            "name": "0",
            "value": 1,
            "created_at": "2017-03-28T22:11:16.610298Z",
            "language": "en",
            "app_id": "main"
          },
          {
            "id": "@conceptID2",
            "name": "1",
            "value": 1,
            "created_at": "2017-03-28T22:11:16.610298Z",
            "language": "en",
            "app_id": "main"
          }
        ]
      },
      "type": "facedetect",
      "type_ext": "facedetect-demographics"
    },
    "model_version": {
      "id": "@modelVersionID",
      "created_at": "2016-12-23T06:08:44.271674Z",
      "status": {
        "code": 21100,
        "description": "Model trained successfully"
      },
      "active_concept_count": 104,
      "train_stats": {}
    },
    "display_name": "Demographics"
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getModel(ModelType::color(), '@modelID')->executeSync();
        $this->assertTrue($response->isSuccessful());

        /** @var DemographicsModel $model */
        $model = $response->get();
        $this->assertEquals('@modelID', $model->modelID());
        $this->assertEquals('demographics', $model->name());
        $this->assertEquals('@modelVersionID', $model->modelVersion()->id());

        /** @var DemographicsOutputInfo $outputInfo */
        $outputInfo = $model->outputInfo();
        $concepts = $outputInfo->concepts();

        $this->assertEquals('@conceptID1', $concepts[0]->id());
        $this->assertEquals('@conceptID2', $concepts[1]->id());
    }

    public function testDemographicsPredict()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "outputs": [
    {
      "id": "@outputID",
      "status": {
        "code": 10000,
        "description": "Ok"
      },
      "created_at": "2019-01-30T10:48:22.463688278Z",
      "model": {
        "id": "@modelID",
        "name": "demographics",
        "created_at": "2016-12-23T06:08:44.271674Z",
        "app_id": "main",
        "output_info": {
          "message": "Show output_info with: GET /models/{model_id}/output_info",
          "type": "facedetect",
          "type_ext": "facedetect-demographics"
        },
        "model_version": {
          "id": "@modelVersionID",
          "created_at": "2016-12-23T06:08:44.271674Z",
          "status": {
            "code": 21100,
            "description": "Model trained successfully"
          },
          "train_stats": {}
        },
        "display_name": "Demographics"
      },
      "input": {
        "id": "@inputID",
        "data": {
          "image": {
            "url": "@url"
          }
        }
      },
      "data": {
        "regions": [
          {
            "id": "@regionID",
            "region_info": {
              "bounding_box": {
                "top_row": 0.1,
                "left_col": 0.2,
                "bottom_row": 0.3,
                "right_col": 0.4
              }
            },
            "data": {
              "face": {
                "age_appearance": {
                  "concepts": [
                    {
                      "id": "@ageConcept1",
                      "name": "77",
                      "value": 0.93078935,
                      "app_id": "main"
                    },
                    {
                      "id": "@ageConcept2",
                      "name": "78",
                      "value": 0.92458177,
                      "app_id": "main"
                    }
                  ]
                },
                "gender_appearance": {
                  "concepts": [
                    {
                      "id": "@genderConcept1",
                      "name": "masculine",
                      "value": 0.88848364,
                      "app_id": "main"
                    },
                    {
                      "id": "@genderConcept2",
                      "name": "feminine",
                      "value": 0.111516364,
                      "app_id": "main"
                    }
                  ]
                },
                "multicultural_appearance": {
                  "concepts": [
                    {
                      "id": "@culturalConcept1",
                      "name": "black or african american",
                      "value": 0.9993645,
                      "app_id": "main"
                    },
                    {
                      "id": "@culturalConcept2",
                      "name": "native hawaiian or pacific islander",
                      "value": 0.011455884,
                      "app_id": "main"
                    }
                  ]
                }
              }
            }
          }
        ]
      }
    }
  ]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->predict(ModelType::demographics(), "", new ClarifaiURLImage("@url"))
            ->executeSync();

        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "data": {
        "image": {
          "url": "@url"
        }
      }
    }
  ]
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());

        /** @var ClarifaiOutput $output */
        $output = $response->get();

        $this->assertEquals('@inputID', $output->input()->id());
        $this->assertEquals('@outputID', $output->id());

        /** @var Demographics $demo */
        $demo = $output->data()[0];

        $this->assertEquals(new Crop(0.1, 0.2, 0.3, 0.4), $demo->crop());

        $this->assertEquals(new Crop(0.1, 0.2, 0.3, 0.4), $demo->crop());

        $this->assertEquals('@ageConcept1', $demo->ageAppearanceConcepts()[0]->id());
        $this->assertEquals('@ageConcept2', $demo->ageAppearanceConcepts()[1]->id());

        $this->assertEquals('@genderConcept1', $demo->genderAppearanceConcepts()[0]->id());
        $this->assertEquals('@genderConcept2', $demo->genderAppearanceConcepts()[1]->id());

        $this->assertEquals('@culturalConcept1', $demo->multiculturalAppearanceConcepts()[0]->id());
        $this->assertEquals('@culturalConcept2', $demo->multiculturalAppearanceConcepts()[1]->id());
    }

    public function testEmbeddingGetModel()
    {
        $getResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "model": {
    "id": "@modelID",
    "name": "general",
    "created_at": "2016-06-17T22:01:04.144732Z",
    "app_id": "main",
    "output_info": {
      "type": "embed",
      "type_ext": "embed"
    },
    "model_version": {
      "id": "@modelVersionID",
      "created_at": "2016-07-13T01:19:12.147644Z",
      "status": {
        "code": 21100,
        "description": "Model trained successfully"
      },
      "train_stats": {}
    },
    "display_name": "General Embedding"
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getModel(ModelType::embedding(), '@modelID')->executeSync();
        $this->assertTrue($response->isSuccessful());

        /** @var EmbeddingModel $model */
        $model = $response->get();
        $this->assertEquals('@modelID', $model->modelID());
        $this->assertEquals('general', $model->name());
        $this->assertEquals('embed', $model->outputInfo()->typeExt());
        $this->assertEquals('@modelVersionID', $model->modelVersion()->id());
    }

    public function testEmbeddingPredict()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "outputs": [
    {
      "id": "@outputID",
      "status": {
        "code": 10000,
        "description": "Ok"
      },
      "created_at": "2019-01-30T15:53:21.949095428Z",
      "model": {
        "id": "@modelID",
        "name": "general",
        "created_at": "2016-06-17T22:01:04.144732Z",
        "app_id": "main",
        "output_info": {
          "message": "Show output_info with: GET /models/{model_id}/output_info",
          "type": "embed",
          "type_ext": "embed"
        },
        "model_version": {
          "id": "@modelVersionID",
          "created_at": "2016-07-13T01:19:12.147644Z",
          "status": {
            "code": 21100,
            "description": "Model trained successfully"
          },
          "train_stats": {}
        },
        "display_name": "General Embedding"
      },
      "input": {
        "id": "@inputID",
        "data": {
          "image": {
            "url": "@url"
          }
        }
      },
      "data": {
        "embeddings": [
          {
            "vector": [
              0.1,
              0.2,
              0.3
            ],
            "num_dimensions": 3
          }
        ]
      }
    }
  ]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->predict(ModelType::embedding(), "", new ClarifaiURLImage("@url"))
            ->executeSync();

        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "data": {
        "image": {
          "url": "@url"
        }
      }
    }
  ]
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());

        /** @var ClarifaiOutput $output */
        $output = $response->get();

        $this->assertEquals('@inputID', $output->input()->id());
        $this->assertEquals('@outputID', $output->id());

        /** @var Embedding $embedding */
        $embedding = $output->data()[0];

        $this->assertEquals(3, $embedding->numDimensions());
        $this->assertEquals([0.1, 0.2, 0.3], $embedding->vector());
    }

    public function testFaceConceptsGetModel()
    {
        $getResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "model": {
    "id": "@modelID",
    "name": "@modelName",
    "created_at": "2017-05-16T19:20:38.733764Z",
    "app_id": "main",
    "output_info": {
      "data": {
        "concepts": [
          {
            "id": "@conceptID1",
            "name": "deborah kagan",
            "value": 1,
            "created_at": "2016-10-25T19:28:34.869737Z",
            "language": "en",
            "app_id": "main"
          },
          {
            "id": "@conceptID2",
            "name": "deborah kara unger",
            "value": 1,
            "created_at": "2016-10-25T19:28:34.869737Z",
            "language": "en",
            "app_id": "main"
          },
          {
            "id": "@conceptID3",
            "name": "deborah kerr",
            "value": 1,
            "created_at": "2016-10-25T19:28:34.869737Z",
            "language": "en",
            "app_id": "main"
          }
        ]
      },
      "type": "concept",
      "type_ext": "facedetect-identity"
    },
    "model_version": {
      "id": "@modelVersionID",
      "created_at": "2016-10-25T19:30:38.541073Z",
      "status": {
        "code": 21100,
        "description": "Model trained successfully"
      },
      "active_concept_count": 10553,
      "train_stats": {}
    },
    "display_name": "Celebrity"
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getModel(ModelType::faceConcepts(), '@modelID')->executeSync();
        $this->assertTrue($response->isSuccessful());

        /** @var FaceConceptsModel $model */
        $model = $response->get();
        $this->assertEquals('@modelID', $model->modelID());
        $this->assertEquals('@modelName', $model->name());
        $this->assertEquals('facedetect-identity', $model->outputInfo()->typeExt());
        $this->assertEquals('@modelVersionID', $model->modelVersion()->id());

        $concepts = $model->outputInfo()->concepts();
        $this->assertEquals('@conceptID1', $concepts[0]->id());
        $this->assertEquals('@conceptID2', $concepts[1]->id());
        $this->assertEquals('@conceptID3', $concepts[2]->id());
    }

    public function testFaceConceptsPredict()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "outputs": [
    {
      "id": "@outputID",
      "status": {
        "code": 10000,
        "description": "Ok"
      },
      "created_at": "2019-01-30T16:12:05.692036673Z",
      "model": {
        "id": "@modelID",
        "name": "celeb-v1.3",
        "created_at": "2016-10-25T19:30:38.541073Z",
        "app_id": "main",
        "output_info": {
          "message": "Show output_info with: GET /models/{model_id}/output_info",
          "type": "concept",
          "type_ext": "facedetect-identity"
        },
        "model_version": {
          "id": "@modelVersionID",
          "created_at": "2016-10-25T19:30:38.541073Z",
          "status": {
            "code": 21100,
            "description": "Model trained successfully"
          },
          "train_stats": {}
        },
        "display_name": "Celebrity"
      },
      "input": {
        "id": "@inputID",
        "data": {
          "image": {
            "url": "@url"
          }
        }
      },
      "data": {
        "regions": [
          {
            "id": "@regionID1",
            "region_info": {
              "bounding_box": {
                "top_row": 0.1,
                "left_col": 0.2,
                "bottom_row": 0.3,
                "right_col": 0.4
              }
            },
            "data": {
              "face": {
                "identity": {
                  "concepts": [
                    {
                      "id": "@conceptID11",
                      "name": "suri cruise",
                      "value": 0.00035361873,
                      "app_id": "main"
                    },
                    {
                      "id": "@conceptID12",
                      "name": "daphne blunt",
                      "value": 0.00023266333,
                      "app_id": "main"
                    }
                  ]
                }
              }
            }
          },
          {
            "id": "@regionID2",
            "region_info": {
              "bounding_box": {
                "top_row": 0.5,
                "left_col": 0.6,
                "bottom_row": 0.7,
                "right_col": 0.8
              }
            },
            "data": {
              "face": {
                "identity": {
                  "concepts": [
                    {
                      "id": "@conceptID21",
                      "name": "shiloh jolie-pitt",
                      "value": 0.0010930675,
                      "app_id": "main"
                    },
                    {
                      "id": "@conceptID22",
                      "name": "suri cruise",
                      "value": 0.000494421,
                      "app_id": "main"
                    }
                  ]
                }
              }
            }
          }
        ]
      }
    }
  ]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->predict(ModelType::faceConcepts(), "", new ClarifaiURLImage("@url"))
            ->executeSync();

        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "data": {
        "image": {
          "url": "@url"
        }
      }
    }
  ]
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());

        /** @var ClarifaiOutput $output */
        $output = $response->get();

        $this->assertEquals('@inputID', $output->input()->id());
        $this->assertEquals('@outputID', $output->id());

        /** @var FaceConcepts[] $data */
        $data = $output->data();

        $faceConcepts1 = $data[0];
        $this->assertEquals('@conceptID11', $faceConcepts1->concepts()[0]->id());
        $this->assertEquals('@conceptID12', $faceConcepts1->concepts()[1]->id());

        $faceConcepts2 = $data[1];
        $this->assertEquals('@conceptID21', $faceConcepts2->concepts()[0]->id());
        $this->assertEquals('@conceptID22', $faceConcepts2->concepts()[1]->id());
    }

    public function testFaceDetectionGetModel()
    {
        $getResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "model": {
    "id": "@modelID",
    "name": "face",
    "created_at": "2016-10-25T19:30:38.541073Z",
    "app_id": "main",
    "output_info": {
      "type": "facedetect",
      "type_ext": "facedetect"
    },
    "model_version": {
      "id": "@modelVersionID",
      "created_at": "2019-01-17T19:45:49.087547Z",
      "status": {
        "code": 21100,
        "description": "Model trained successfully"
      },
      "train_stats": {}
    },
    "display_name": "Face Detection"
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getModel(ModelType::faceDetection(), '@modelID')->executeSync();
        $this->assertTrue($response->isSuccessful());

        /** @var FaceDetectionModel $model */
        $model = $response->get();
        $this->assertEquals('@modelID', $model->modelID());
        $this->assertEquals('face', $model->name());
        $this->assertEquals('facedetect', $model->outputInfo()->typeExt());
        $this->assertEquals('@modelVersionID', $model->modelVersion()->id());
    }

    public function testFaceDetectionPredict()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "outputs": [
    {
      "id": "@outputID",
      "status": {
        "code": 10000,
        "description": "Ok"
      },
      "created_at": "2019-01-30T16:23:07.989685196Z",
      "model": {
        "id": "@modelID",
        "name": "face",
        "created_at": "2016-10-25T19:30:38.541073Z",
        "app_id": "main",
        "output_info": {
          "message": "Show output_info with: GET /models/{model_id}/output_info",
          "type": "facedetect",
          "type_ext": "facedetect"
        },
        "model_version": {
          "id": "@modelVersionID",
          "created_at": "2019-01-17T19:45:49.087547Z",
          "status": {
            "code": 21100,
            "description": "Model trained successfully"
          },
          "train_stats": {}
        },
        "display_name": "Face Detection"
      },
      "input": {
        "id": "@inputID",
        "data": {
          "image": {
            "url": "@url"
          }
        }
      },
      "data": {
        "regions": [
          {
            "id": "@regionID1",
            "region_info": {
              "bounding_box": {
                "top_row": 0.1,
                "left_col": 0.2,
                "bottom_row": 0.3,
                "right_col": 0.4
              }
            }
          },
          {
            "id": "@regionID2",
            "region_info": {
              "bounding_box": {
                "top_row": 0.5,
                "left_col": 0.6,
                "bottom_row": 0.7,
                "right_col": 0.8
              }
            }
          }
        ]
      }
    }
  ]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->predict(ModelType::faceDetection(), "", new ClarifaiURLImage("@url"))
            ->executeSync();

        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "data": {
        "image": {
          "url": "@url"
        }
      }
    }
  ]
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());

        /** @var ClarifaiOutput $output */
        $output = $response->get();

        $this->assertEquals('@inputID', $output->input()->id());
        $this->assertEquals('@outputID', $output->id());

        /** @var FaceDetection[] $data */
        $data = $output->data();

        $faceDetection1 = $data[0];
        $this->assertEquals(new Crop(0.1, 0.2, 0.3, 0.4), $faceDetection1->crop());

        $faceDetection2 = $data[1];
        $this->assertEquals(new Crop(0.5, 0.6, 0.7, 0.8), $faceDetection2->crop());
    }

    public function testFaceEmbeddingGetModel()
    {
        $getResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "model": {
    "id": "@modelID",
    "name": "face",
    "created_at": "2016-10-25T19:30:38.541073Z",
    "app_id": "main",
    "output_info": {
      "type": "embed",
      "type_ext": "detect-embed"
    },
    "model_version": {
      "id": "@modelVersionID",
      "created_at": "2016-10-25T19:30:38.541073Z",
      "status": {
        "code": 21100,
        "description": "Model trained successfully"
      },
      "train_stats": {}
    },
    "display_name": "Face Embedding"
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getModel(ModelType::faceEmbedding(), '@modelID')->executeSync();
        $this->assertTrue($response->isSuccessful());

        /** @var FaceEmbeddingModel $model */
        $model = $response->get();
        $this->assertEquals('@modelID', $model->modelID());
        $this->assertEquals('face', $model->name());
        $this->assertEquals('detect-embed', $model->outputInfo()->typeExt());
        $this->assertEquals('@modelVersionID', $model->modelVersion()->id());
    }

    public function testFaceEmbeddingPredict()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "outputs": [
    {
      "id": "@outputID",
      "status": {
        "code": 10000,
        "description": "Ok"
      },
      "created_at": "2019-01-30T16:28:58.518441695Z",
      "model": {
        "id": "@modelID",
        "name": "face",
        "created_at": "2016-10-25T19:30:38.541073Z",
        "app_id": "main",
        "output_info": {
          "message": "Show output_info with: GET /models/{model_id}/output_info",
          "type": "embed",
          "type_ext": "detect-embed"
        },
        "model_version": {
          "id": "@modelVersionID",
          "created_at": "2016-10-25T19:30:38.541073Z",
          "status": {
            "code": 21100,
            "description": "Model trained successfully"
          },
          "train_stats": {}
        },
        "display_name": "Face Embedding"
      },
      "input": {
        "id": "@inputID",
        "data": {
          "image": {
            "url": "@url"
          }
        }
      },
      "data": {
        "regions": [
          {
            "id": "@regionID",
            "region_info": {
              "bounding_box": {
                "top_row": 0.1,
                "left_col": 0.2,
                "bottom_row": 0.3,
                "right_col": 0.4
              }
            },
            "data": {
              "embeddings": [
                {
                  "vector": [
                    0.1,
                    0.2,
                    0.3
                  ],
                  "num_dimensions": 3
                }
              ]
            }
          }
        ]
      }
    }
  ]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->predict(ModelType::faceEmbedding(), "", new ClarifaiURLImage("@url"))
            ->executeSync();

        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "data": {
        "image": {
          "url": "@url"
        }
      }
    }
  ]
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());

        /** @var ClarifaiOutput $output */
        $output = $response->get();

        $this->assertEquals('@inputID', $output->input()->id());
        $this->assertEquals('@outputID', $output->id());

        /** @var FaceEmbedding[] $data */
        $data = $output->data();

        $faceEmbedding = $data[0];
        $this->assertEquals(new Crop(0.1, 0.2, 0.3, 0.4), $faceEmbedding->crop());
        $this->assertEquals([0.1, 0.2, 0.3], $faceEmbedding->embeddings()[0]->vector());
    }

    public function testFocusGetModel()
    {
        $getResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "model": {
    "id": "@modelID",
    "name": "focus",
    "created_at": "2017-03-06T22:57:00.660603Z",
    "app_id": "main",
    "output_info": {
      "type": "blur",
      "type_ext": "focus"
    },
    "model_version": {
      "id": "@modelVersionID",
      "created_at": "2017-03-06T22:57:00.684652Z",
      "status": {
        "code": 21100,
        "description": "Model trained successfully"
      },
      "train_stats": {}
    },
    "display_name": "Focus"
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getModel(ModelType::focus(), '@modelID')->executeSync();
        $this->assertTrue($response->isSuccessful());

        /** @var FocusModel $model */
        $model = $response->get();
        $this->assertEquals('@modelID', $model->modelID());
        $this->assertEquals('focus', $model->name());
        $this->assertEquals('focus', $model->outputInfo()->typeExt());
        $this->assertEquals('@modelVersionID', $model->modelVersion()->id());
    }

    public function testFocusPredict()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "outputs": [
    {
      "id": "@outputID",
      "status": {
        "code": 10000,
        "description": "Ok"
      },
      "created_at": "2019-01-30T16:36:40.235988209Z",
      "model": {
        "id": "@modelID",
        "name": "focus",
        "created_at": "2017-03-06T22:57:00.660603Z",
        "app_id": "main",
        "output_info": {
          "message": "Show output_info with: GET /models/{model_id}/output_info",
          "type": "blur",
          "type_ext": "focus"
        },
        "model_version": {
          "id": "@modelVersionID",
          "created_at": "2017-03-06T22:57:00.684652Z",
          "status": {
            "code": 21100,
            "description": "Model trained successfully"
          },
          "train_stats": {}
        },
        "display_name": "Focus"
      },
      "input": {
        "id": "@inputID",
        "data": {
          "image": {
            "url": "@url"
          }
        }
      },
      "data": {
        "focus": {
          "density": 0.7,
          "value": 0.8
        },
        "regions": [
          {
            "id": "@regionID",
            "region_info": {
              "bounding_box": {
                "top_row": 0.1,
                "left_col": 0.2,
                "bottom_row": 0.3,
                "right_col": 0.4
              }
            },
            "data": {
              "focus": {
                "density": 0.5,
                "value": 0.6
              }
            }
          }
        ]
      }
    }
  ]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->predict(ModelType::focus(), "", new ClarifaiURLImage("@url"))
            ->executeSync();

        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "data": {
        "image": {
          "url": "@url"
        }
      }
    }
  ]
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());

        /** @var ClarifaiOutput $output */
        $output = $response->get();

        $this->assertEquals('@inputID', $output->input()->id());
        $this->assertEquals('@outputID', $output->id());

        /** @var Focus[] $data */
        $data = $output->data();

        $focus = $data[0];
        $this->assertEquals(new Crop(0.1, 0.2, 0.3, 0.4), $focus->crop());
        $this->assertEquals(0.5, $focus->density());
        $this->assertEquals(0.8, $focus->value());
        // TODO(Rok) HIGH: Correctly expose Crop both density/value numbers.
    }

    public function testLogoGetModel()
    {
        $getResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "model": {
    "id": "@modelID",
    "name": "logo",
    "created_at": "2017-03-06T22:57:00.707216Z",
    "app_id": "main",
    "output_info": {
      "data": {
        "concepts": [
          {
            "id": "@conceptID1",
            "name": "3M",
            "value": 1,
            "created_at": "2017-05-22T18:13:37.682503Z",
            "language": "en",
            "app_id": "main"
          },
          {
            "id": "@conceptID2",
            "name": "3Musketeers",
            "value": 1,
            "created_at": "2017-05-22T18:13:37.682503Z",
            "language": "en",
            "app_id": "main"
          }
        ]
      },
      "type": "concept",
      "type_ext": "detection"
    },
    "model_version": {
      "id": "@modelVersionID",
      "created_at": "2017-03-06T22:57:05.625525Z",
      "status": {
        "code": 21100,
        "description": "Model trained successfully"
      },
      "active_concept_count": 561,
      "train_stats": {}
    },
    "display_name": "Logo"
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getModel(ModelType::logo(), '@modelID')->executeSync();
        $this->assertTrue($response->isSuccessful());

        /** @var LogoModel $model */
        $model = $response->get();
        $this->assertEquals('@modelID', $model->modelID());
        $this->assertEquals('logo', $model->name());
        $this->assertEquals('detection', $model->outputInfo()->typeExt());
        $this->assertEquals('@modelVersionID', $model->modelVersion()->id());

        $concepts = $model->outputInfo()->concepts();

        $this->assertEquals('@conceptID1', $concepts[0]->id());
        $this->assertEquals('3M', $concepts[0]->name());

        $this->assertEquals('@conceptID2', $concepts[1]->id());
        $this->assertEquals('3Musketeers', $concepts[1]->name());
    }

    public function testLogoPredict()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "outputs": [
    {
      "id": "@outputID",
      "status": {
        "code": 10000,
        "description": "Ok"
      },
      "created_at": "2019-01-30T16:45:27.083256618Z",
      "model": {
        "id": "@modelID",
        "name": "logo",
        "created_at": "2017-03-06T22:57:00.707216Z",
        "app_id": "main",
        "output_info": {
          "message": "Show output_info with: GET /models/{model_id}/output_info",
          "type": "concept",
          "type_ext": "detection"
        },
        "model_version": {
          "id": "@modelVersionID",
          "created_at": "2017-03-06T22:57:05.625525Z",
          "status": {
            "code": 21100,
            "description": "Model trained successfully"
          },
          "train_stats": {}
        },
        "display_name": "Logo"
      },
      "input": {
        "id": "@inputID",
        "data": {
          "image": {
            "url": "@url"
          }
        }
      },
      "data": {
        "regions": [
          {
            "id": "@regionID",
            "region_info": {
              "bounding_box": {
                "top_row": 0.1,
                "left_col": 0.2,
                "bottom_row": 0.3,
                "right_col": 0.4
              }
            },
            "data": {
              "concepts": [
                {
                  "id": "@conceptID1",
                  "name": "I Can't Believe It's Not Butter",
                  "value": 0.092014045
                },
                {
                  "id": "@conceptID2",
                  "name": "Pepsi",
                  "value": 0.06332539
                }
              ]
            }
          }
        ]
      }
    }
  ]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->predict(ModelType::logo(), "", new ClarifaiURLImage("@url"))
            ->executeSync();

        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "data": {
        "image": {
          "url": "@url"
        }
      }
    }
  ]
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());

        /** @var ClarifaiOutput $output */
        $output = $response->get();

        $this->assertEquals('@inputID', $output->input()->id());
        $this->assertEquals('@outputID', $output->id());

        /** @var Logo[] $data */
        $data = $output->data();

        $logo = $data[0];
        $this->assertEquals(new Crop(0.1, 0.2, 0.3, 0.4), $logo->crop());

        $concepts = $logo->concepts();
        $this->assertEquals('@conceptID1', $concepts[0]->id());
        $this->assertEquals('@conceptID2', $concepts[1]->id());
    }

    public function testVideoGetModel()
    {
        $getResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "model": {
    "id": "@modelID",
    "name": "nsfw-v1.0",
    "created_at": "2016-09-17T22:18:59.955626Z",
    "app_id": "main",
    "output_info": {
      "data": {
        "concepts": [
          {
            "id": "@conceptID1",
            "name": "nsfw",
            "value": 1,
            "created_at": "2016-09-17T22:18:50.338072Z",
            "language": "en",
            "app_id": "main"
          },
          {
            "id": "@conceptID2",
            "name": "sfw",
            "value": 1,
            "created_at": "2016-09-17T22:18:50.338072Z",
            "language": "en",
            "app_id": "main"
          }
        ]
      },
      "type": "concept",
      "type_ext": "concept"
    },
    "model_version": {
      "id": "@modelVersionID",
      "created_at": "2018-01-23T19:25:09.618692Z",
      "status": {
        "code": 21100,
        "description": "Model trained successfully"
      },
      "active_concept_count": 2,
      "train_stats": {}
    },
    "display_name": "NSFW"
  }
}
EOD;
        $httpClient = new FkClarifaiHttpClientTest($getResponse, null, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->getModel(ModelType::video(), '@modelID')->executeSync();
        $this->assertTrue($response->isSuccessful());

        /** @var VideoModel $model */
        $model = $response->get();
        $this->assertEquals('@modelID', $model->modelID());
        $this->assertEquals('nsfw-v1.0', $model->name());
        $this->assertEquals('concept', $model->outputInfo()->typeExt());
        $this->assertEquals('@modelVersionID', $model->modelVersion()->id());

        $concepts = $model->outputInfo()->concepts();

        $this->assertEquals('@conceptID1', $concepts[0]->id());
        $this->assertEquals('nsfw', $concepts[0]->name());

        $this->assertEquals('@conceptID2', $concepts[1]->id());
        $this->assertEquals('sfw', $concepts[1]->name());
    }

    public function testFramePredict()
    {
        $postResponse = <<<EOD
{
  "status": {
    "code": 10000,
    "description": "Ok"
  },
  "outputs": [
    {
      "id": "@outputID",
      "status": {
        "code": 10000,
        "description": "Ok"
      },
      "created_at": "2019-01-30T16:52:30.993694779Z",
      "model": {
        "id": "@modelID",
        "name": "nsfw-v1.0",
        "created_at": "2016-09-17T22:18:59.955626Z",
        "app_id": "main",
        "output_info": {
          "message": "Show output_info with: GET /models/{model_id}/output_info",
          "type": "concept",
          "type_ext": "concept"
        },
        "model_version": {
          "id": "@modelVersionID",
          "created_at": "2018-01-23T19:25:09.618692Z",
          "status": {
            "code": 21100,
            "description": "Model trained successfully"
          },
          "train_stats": {}
        },
        "display_name": "NSFW"
      },
      "input": {
        "id": "@inputID",
        "data": {
          "video": {
            "url": "@url"
          }
        }
      },
      "data": {
        "frames": [
          {
            "frame_info": {
              "index": 0,
              "time": 0
            },
            "data": {
              "concepts": [
                {
                  "id": "@conceptID1",
                  "name": "sfw",
                  "value": 0.99452126,
                  "app_id": "main"
                },
                {
                  "id": "@conceptID2",
                  "name": "nsfw",
                  "value": 0.005478708,
                  "app_id": "main"
                }
              ]
            }
          }
        ]
      }
    }
  ]
}
EOD;

        $httpClient = new FkClarifaiHttpClientTest(null, $postResponse, null, null);
        $client = new ClarifaiClient("", $httpClient);
        $response = $client->predict(ModelType::video(), "", new ClarifaiURLImage("@url"))
            ->executeSync();

        $expectedRequestBody = <<< EOD
{
  "inputs": [
    {
      "data": {
        "image": {
          "url": "@url"
        }
      }
    }
  ]
}
EOD;
        $this->assertEquals(json_decode($expectedRequestBody, true), $httpClient->postedBody());

        /** @var ClarifaiOutput $output */
        $output = $response->get();

        $this->assertEquals('@inputID', $output->input()->id());
        $this->assertEquals('@outputID', $output->id());

        /** @var Frame[] $data */
        $data = $output->data();

        $frame = $data[0];

        $concepts = $frame->concepts();
        $this->assertEquals('@conceptID1', $concepts[0]->id());
        $this->assertEquals('@conceptID2', $concepts[1]->id());
    }
}
