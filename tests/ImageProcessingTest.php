<?php


class ImageProcessingTest extends \PHPUnit_Framework_TestCase {

  private static $GOOGLE_DRIVE  = '905aaac0-06bb-11e7-83da-0b30de6ae4a2';
  private static $AWS_S3        = 'f1b5b200-2908-11e7-b67a-1709de57da39';

  // --- --- ---

  private $client;


  public function __construct() {

    // Change API endpoint to internal dev server for testing.
    \Zara4\API\Communication\Config::enterDevelopmentMode();

    // Dev credentials.
    $clientId = "khXKtxyBhoAnVfCbRVfuXNnTd1r8es5z6ZW";
    $clientSecret = "mjEVHmM8GsALCS2VnpgtGnblUmZVxGjhMG8";

    $this->client = new \Zara4\API\Client($clientId, $clientSecret);
  }


  /**
   * Test image optimise by file upload.
   */
  public function testFileUploadImageOptimise() {

    $this->client->setIpToForwardFor('1.3.3.7');

    $request = new \Zara4\API\ImageProcessing\LocalImageRequest('test-images/001.jpg');
    $response = $this->client->processImage($request);

    //$this->assertEquals("ok", $response->{"status"});

    //$this->assertTrue(isset($response->{"compression"}));
    //$compression = $response->{"compression"};

    //$this->assertTrue(isset($compression->{"bytes-original"}));
    //$this->assertTrue(isset($compression->{"bytes-compressed"}));
    //$this->assertTrue(isset($compression->{"bytes-saving"}));
    //$this->assertTrue(isset($compression->{"ratio-compression"}));
    //$this->assertTrue(isset($compression->{"percentage-saving"}));
  }


  /**
   * Test image optimise by url.
   */
  public function testUrlImageOptimise() {

    $this->client->setIpToForwardFor("1.3.3.7");

    $request = new \Zara4\API\ImageProcessing\RemoteImageRequest("https://zara4.com/img/comparison/beach/original.jpg");
    $response = $this->client->processImage($request);

  }


  /**
   * Test image optimise by url.
   */
  public function testCloudImageOptimise() {

    $this->client->setIpToForwardFor('1.3.3.7');

    $request = new \Zara4\API\ImageProcessing\CloudImageRequest(
      self::$GOOGLE_DRIVE, '0B_x2cioi5h8IUzlFU29sUERCUms'
    );
    $response = $this->client->processImage($request);

  }


  /**
   *
   */
  public function testCloudUpload() {

    $request = new \Zara4\API\ImageProcessing\LocalImageRequest('test-images/001.jpg');

    $destinationDriveId  = self::$GOOGLE_DRIVE;
    $destinationFileName = uniqid('LOCAL_IMAGE__');
    $destinationParentId = '0B_x2cioi5h8ITTBNSzJOc3V2aWc';
    $request->uploadToCloud($destinationDriveId, $destinationFileName, $destinationParentId);

    $response = $this->client->processImage($request);

  }


  /**
   * Test image optimise by url.
   */
  public function testCloudImageOptimiseWithCloudUpload() {

    $this->client->setIpToForwardFor('1.3.3.7');

    $request = new \Zara4\API\ImageProcessing\CloudImageRequest(
      self::$GOOGLE_DRIVE, '0B_x2cioi5h8IX1NwYkNDcE96Tlk'
    );

    $destinationDriveId  = self::$GOOGLE_DRIVE;
    $destinationFileName = uniqid('CLOUD_IMAGE_');
    $destinationParentId = '0B_x2cioi5h8ITTBNSzJOc3V2aWc';
    $request->uploadToCloud($destinationDriveId, $destinationFileName, $destinationParentId);


    $response = $this->client->processImage($request);

  }



  /**
   *
   */
  public function testAwsS3CloudUpload() {

    $request = new \Zara4\API\ImageProcessing\LocalImageRequest('test-images/001.jpg');

    $destinationDriveId  = self::$AWS_S3;
    $destinationFileName = uniqid('LOCAL_IMAGE__');
    $destinationParentId = '';
    $request->uploadToCloud($destinationDriveId, $destinationFileName, $destinationParentId);

    $response = $this->client->processImage($request);

  }


  /**
   * Test image optimise by url.
   */
  public function testAwsS3CloudDownload() {

    $this->client->setIpToForwardFor('1.3.3.7');

    $request = new \Zara4\API\ImageProcessing\CloudImageRequest(self::$AWS_S3, '001.jpg');

    $destinationDriveId  = self::$AWS_S3;
    $destinationFileName = uniqid('001_COMPRESSED__');
    $destinationParentId = 'test';
    $request->uploadToCloud($destinationDriveId, $destinationFileName, $destinationParentId);

    $response = $this->client->processImage($request);

  }


}