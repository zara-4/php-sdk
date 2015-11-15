<?php

use Zara4\API\Communication\Authentication\ApplicationAuthenticator;
use Zara4\API\ImageProcessing\Usage;


class UsageTest extends \PHPUnit_Framework_TestCase {

  private $accessToken;


  public function __construct() {

    // Change API endpoint to internal dev server for testing.
    \Zara4\API\Communication\Config::set_BASE_URL("http://dev.zara4.com");

    // Dev credentials.
    $clientId = "70INWEK951yWvxfvgHGr3fjXvaN8NMXGQoD";
    $clientSecret = "iTDTkMJmcGMZxZKZCQvNby4aSGMG4rYJD77";

    $authenticator = (new ApplicationAuthenticator($clientId, $clientSecret))
      ->withImageProcessing()->withUsage();

    // Acquire access token.
    $this->accessToken = $authenticator->acquireAccessToken();
  }



  public function testReadCurrentBillingPeriodUsage() {
    var_dump(Usage::currentBillingUsage($this->accessToken));
  }

} 