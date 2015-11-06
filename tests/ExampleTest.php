<?php

use Zara4\API\Communication\Grant\ClientCredentialsGrantRequest;
use Zara4\API\ImageProcessing\Image;


class ExampleTest extends \PHPUnit_Framework_TestCase {


  public function testExample() {

    $clientId = "70INWEK951yWvxfvgHGr3fjXvaN8NMXGQoD";
    $clientSecret = "iTDTkMJmcGMZxZKZCQvNby4aSGMG4rYJD77";


    $accessToken = (new ClientCredentialsGrantRequest($clientId, $clientSecret))
      ->withImageProcessing()
      ->getTokens()
      ->{"access_token"};

    echo $accessToken;


    $resonse = Image::optimiseImageFromFile("test-images/Ataraxia.jpg", ["access_token" => $accessToken]);

    var_dump($resonse);

    //$this->assertTrue(true);
  }


}