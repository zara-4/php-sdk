# Zara 4 PHP SDK

PHP SDK for the Zara 4 [Image Compression](https://zara4.com) API. For more information see Zara 4 API [documentation](https://zara4.com/docs/getting-started/welcome)


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



### Cloud Image

To process images from a cloud location (such as a Google Drive or Dropbox), you should use a CloudImageRequest. This downloads the image from the cloud location to Zara 4 for processing.

Example usage
```php
use Zara4\API\Client;
use Zara4\API\ImageProcessing\CloudImageRequest;
use Zara4\API\ImageProcessing\ProcessedImage;

$apiClient = new Client(API_CLIENT_ID, API_CLIENT_SECRET);
$cloudDriveId = '905aaac0-06bb-11e7-83da-0b30de6ae4a2'; // Replace with your cloud drive id
$cloudFileId  = '0B_x2cioi5h8IX1NwYkNDcE96Tlk'; // Replace with the id of the file you wish to compress
$originalImage = new CloudImageRequest($cloudDriveId, $cloudFileId);
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






## Uploading Compressed Images To Cloud Storage

```php
$request = new \Zara4\API\ImageProcessing\LocalImageRequest('test-images/001.jpg');


// The id of the cloud storage drive to upload to (Replace with your cloud drive id)
// You can manage your Cloud Storage from https://zara4.com/account/cloud-storage
$destinationDriveId = '905aaac0-06bb-11e7-83da-0b30de6ae4a2';

// The name the uploaded file should be given on you Cloud Storage
$destinationFileName = 'YOUR FILE NAME';

// You can also specify the folder the compressed image should be uploaded to
// If you do not wish to specify a parent folder, set $destinationParentId = null
$destinationParentId = '0B_x2cioi5h8ITTBNSzJOc3V2aWc';

$request->uploadToCloud($destinationDriveId, $destinationFileName, $destinationParentId);


$response = $this->client->processImage($request);
```