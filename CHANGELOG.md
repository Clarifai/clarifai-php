## [[0.7.0]](https://github.com/Clarifai/clarifai-php/releases/tag/0.7.0) - [Packagist](https://packagist.org/packages/clarifai/clarifai-php#0.7.0) - 2020-02-16

See the API changes for more details on the Face proto deprecation and the facedetect* model type cleanup:
https://docs.clarifai.com/product-updates/upcoming-api-changes

### Added
- Expose input's status
- DetectionModel

### Removed
- Cropping image in search
- DemographicsModel, LogoModel, FaceConceptsModel, FaceDetectionModel, FocusModel.
- Feedback


## [[0.6.2]](https://github.com/Clarifai/clarifai-php/releases/tag/0.6.2) - [Packagist](https://packagist.org/packages/clarifai/clarifai-php#0.6.2) - 2019-10-02

### Added
- Getting model by version ID

### Fixed
- Skip unknown models in GetModelsRequest
- Make pagination work with search


## [[0.6.1]](https://github.com/Clarifai/clarifai-php/releases/tag/0.6.1) - [Packagist](https://packagist.org/packages/clarifai/clarifai-php#0.6.1) - 2019-05-30

### Fixed
- One class per file, to be compliant with PSR-4
- Adding inputs with negative concepts


## [[0.6.0]](https://github.com/Clarifai/clarifai-php/releases/tag/0.6.0) - [Packagist](https://packagist.org/packages/clarifai/clarifai-php#0.6.0) - 2018-12-10

### Added
- Sample milliseconds parameter for video prediction.
- Support for workflow image file prediction.

### Fixed
- Shorthand predict methods to use the new HTTP client field.


## [[0.5.0]](https://github.com/Clarifai/clarifai-php/releases/tag/0.5.0) - [Packagist](https://packagist.org/packages/clarifai/clarifai-php#0.5.0) - 2018-10-22

### Added
- Support for custom face recognition.


## [[0.4.0]](https://github.com/Clarifai/clarifai-php/releases/tag/0.4.0) - [Packagist](https://packagist.org/packages/clarifai/clarifai-php#0.4.0) - 2018-10-18

### Added
- Moderation solution.


## [[0.3.0]](https://github.com/Clarifai/clarifai-php/releases/tag/0.3.0) - [Packagist](https://packagist.org/packages/clarifai/clarifai-php#0.3.0) - 2018-09-10

### Added
- Expose all predict output data.


## [[0.2.0]](https://github.com/Clarifai/clarifai-php/releases/tag/0.2.0) - [Packagist](https://packagist.org/packages/clarifai/clarifai-php#0.2.0) - 2018-07-18

### Added
- Support for input metadata.

### Fixed
- Input crop deserialization.


## [[0.1.1]](https://github.com/Clarifai/clarifai-php/releases/tag/0.1.1) - [Packagist](https://packagist.org/packages/clarifai/clarifai-php#0.1.1) - 2018-06-29

### Changed
- Dependencies updated.


## [[0.1]](https://github.com/Clarifai/clarifai-php/releases/tag/0.1) - [Packagist](https://packagist.org/packages/clarifai/clarifai-php#0.1) - 2018-06-29

### Added
- Initial release.
