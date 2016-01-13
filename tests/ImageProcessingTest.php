<?php

use Zara4\API\Communication\Authentication\ApplicationAuthenticator;
use Zara4\API\ImageProcessing\Image;
use Zara4\API\ImageProcessing\Usage;


class ImageProcessingTest extends \PHPUnit_Framework_TestCase {

  private $accessToken;


  public function __construct() {

    // Change API endpoint to internal dev server for testing.
    \Zara4\API\Communication\Config::set_BASE_URL("http://zara4.dev");

    // Dev credentials.
    $clientId = "poy3h5I18Pl3evZOWu8G12jJoA5Eiknd0Nt";
    $clientSecret = "yXkzFextDeRLu1BBqnhd40zbGsQSKCKR3lq";

    $authenticator = (new ApplicationAuthenticator($clientId, $clientSecret))
      ->withImageProcessing()->withUsage();

    // Acquire access token.
    $this->accessToken = $authenticator->acquireAccessToken();
  }


  /**
   * Test image optimise by file upload.
   */
  public function testFileUploadImageOptimise() {
    $response = Image::optimiseImageFromFile(
      "test-images/001.jpg", [], $this->accessToken->token(), "1.3.3.7"
    );

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
    $response = Image::optimiseImageFromUrl(
      "https://zara4.com/img/comparison/beach/original.jpg", [], $this->accessToken->token(), "1.3.3.7"
    );

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