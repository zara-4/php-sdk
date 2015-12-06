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
    $clientId = "rBfPlHoUwQ03Q3iuv69sCwA7sUPdaeLuvYK";
    $clientSecret = "IexRDH5OPgeSkbwWhbY6d5UYFXZCWdqthLn";

    $authenticator = (new ApplicationAuthenticator($clientId, $clientSecret))
      ->withImageProcessing()->withUsage();

    // Acquire access token.
    $this->accessToken = $authenticator->acquireAccessToken();
  }



  //public function testReadCurrentBillingPeriodUsage() {
  //  var_dump(Usage::cumulativeUsageForCurrentBillingUsage($this->accessToken));
  //}


  public function testImageOptimise() {
    $response = Image::optimiseImageFromFile("test-images/001.jpg", ["access_token" => $this->accessToken]);
    var_dump($response);
  }


} 