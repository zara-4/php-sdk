# Zara 4 PHP SDK


## Installation

### Composer

You can install the SDK via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require zara-4/php-sdk
```

To use the SDK, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

```php
require_once('vendor/autoload.php');
```




## Authentication

All authentication with the Zara 4 API is handled by the PHP SDK. You simply need to provide your API_CLIENT_ID and API_CLIENT_SECRET when creating an API Client.

The Zara 4 API uses OAuth authentication, using access tokens to grant access. Access tokens are automatically generated and transparently refreshed by the PHP SDK.

Example API client setup
```php
use Zara4\API\Client;

$apiClient = new Client(API_CLIENT_ID, API_CLIENT_SECRET);
```

To get your API credentials [click here](https://zara4.com/account/api-clients)





## Image Processing

The Zara 4 PHP SDK offers extensive support for image processing, making integrating Zara 4 into your PHP application very simple.

All authentication and communication with the Zara 4 API is automatically handled, meaning you can compress both remote and local images in just 4 lines of code.


### Local Image

To process images on your local machine you should use a LocalImageRequest. This uploads the image from your machine to Zara 4 for processing.

Example usage
```php
use Zara4\API\Client;
use Zara4\API\ImageProcessing\LocalImageRequest;
use Zara4\API\ImageProcessing\ProcessedImage;

$apiClient = new Client(API_CLIENT_ID, API_CLIENT_SECRET);
$originalImage = new LocalImageRequest("/path/to/original-image.jpg");
$processedImage = $apiClient->processImage($originalImage);
$apiClient->downloadProcessedImage($processedImage, "/where/to/save/compressed-image.jpg");
```


### Remote Image

To process images from a remote location (such as a website url), you should use a RemoteImageRequest. This downloads the image from the remote location to Zara 4 for processing. The image url given must be publicly accessible.

Example usage
```php
use Zara4\API\Client;
use Zara4\API\ImageProcessing\RemoteImageRequest;
use Zara4\API\ImageProcessing\ProcessedImage;

$apiClient = new Client(API_CLIENT_ID, API_CLIENT_SECRET);
$originalImage = new RemoteImageRequest("https://example.com/original-image.jpg");
$processedImage = $apiClient->processImage($originalImage);
$apiClient->downloadProcessedImage($processedImage, "/where/to/save/compressed-image.jpg");
```


### Options

You can customise how your images are processed with Zara 4 by altering your request options.

Example usage
```php
use Zara4\API\Client;
use Zara4\API\ImageProcessing\LocalImageRequest;

$apiClient = new Client(API_CLIENT_ID, API_CLIENT_SECRET);
$originalImage = new LocalImageRequest("/path/to/original-image.jpg");

// Change request options
$originalImage->optimisationMode = OptimisationMode::HIGHEST;
$originalImage->outputFormat = OutputFormat::MATCH;
$originalImage->colourEnhancement = ColourEnhancement::IMPROVE_COLOUR;
$originalImage->resizeMode = ResizeMode::NONE;

$processedImage = $apiClient->processImage($originalImage);
$apiClient->downloadProcessedImage($processedImage, "/where/to/save/compressed-image.jpg");
```