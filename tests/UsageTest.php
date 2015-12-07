<?php

use Zara4\API\Communication\Authentication\ApplicationAuthenticator;
use Zara4\API\ImageProcessing\Image;
use Zara4\API\ImageProcessing\Usage;


class UsageTest extends \PHPUnit_Framework_TestCase {

  private $accessToken;


  public function __construct() {

    // Change API endpoint to internal dev server for testing.
    \Zara4\API\Communication\Config::set_BASE_URL("http://zara4.dev");

    // Dev credentials.
    $clientId = "guhqYaNiVqz7F6KLonAviOegPEKUPM8zyq2";
    $clientSecret = "Ah7l96OB4SQhVmtADy30iCIGq1dwaR5icxc";

    $authenticator = (new ApplicationAuthenticator($clientId, $clientSecret))
      ->withImageProcessing()->withUsage();

    // Acquire access token.
    $this->accessToken = $authenticator->acquireAccessToken();
  }



  //public function testReadCurrentBillingPeriodUsage() {
  //  var_dump(Usage::cumulativeUsageForCurrentBillingUsage($this->accessToken));
  //}


  public function testImageOptimise() {
    $response = Image::optimiseImageFromFile(
      "test-images/001.jpg", ["access_token" => $this->accessToken->token()], "1.3.3.7"
    );
    var_dump($response);
  }


} 