<?php


class ImageProcessingTest extends \PHPUnit_Framework_TestCase {

  private $client;


  public function __construct() {

    // Change API endpoint to internal dev server for testing.
    \Zara4\API\Communication\Config::enterDevelopmentMode();

    // Dev credentials.
    $clientId = "poy3h5I18Pl3evZOWu8G12jJoA5Eiknd0Nt";
    $clientSecret = "yXkzFextDeRLu1BBqnhd40zbGsQSKCKR3lq";

    $this->client = new \Zara4\API\Client($clientId, $clientSecret);
  }


  /**
   * Test image optimise by file upload.
   */
  public function testFileUploadImageOptimise() {

    $this->client->setIpToForwardFor("1.3.3.7");

    $request = new \Zara4\API\ImageProcessing\LocalImageRequest("test-images/001.jpg");
    $response = $this->client->processImage($request);



    $this->assertEquals("ok", $response->{"status"});

    $this->assertTrue(isset($response->{"compression"}));
    $compression = $response->{"compression"};

    $this->assertTrue(isset($compression->{"bytes-original"}));
    $this->assertTrue(isset($compression->{"bytes-compressed"}));
    $this->assertTrue(isset($compression->{"bytes-saving"}));
    $this->assertTrue(isset($compression->{"ratio-compression"}));
    $this->assertTrue(isset($compression->{"percentage-saving"}));
  }


  /**
   * Test image optimise by url.
   */
  public function testUrlImageOptimise() {

    $this->client->setIpToForwardFor("1.3.3.7");

    $request = new \Zara4\API\ImageProcessing\RemoteImageRequest("https://zara4.com/img/comparison/beach/original.jpg");
    $response = $this->client->processImage($request);



    $this->assertEquals("ok", $response->{"status"});

    $this->assertTrue(isset($response->{"compression"}));
    $compression = $response->{"compression"};

    $this->assertTrue(isset($compression->{"bytes-original"}));
    $this->assertTrue(isset($compression->{"bytes-compressed"}));
    $this->assertTrue(isset($compression->{"bytes-saving"}));
    $this->assertTrue(isset($compression->{"ratio-compression"}));
    $this->assertTrue(isset($compression->{"percentage-saving"}));
  }


} 