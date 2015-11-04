<?php

use Zara4\API\Communication\Grant\ClientCredentialsGrantRequest;


class ExampleTest extends \PHPUnit_Framework_TestCase {


  public function testExample() {

    $clientId = "70INWEK951yWvxfvgHGr3fjXvaN8NMXGQoD";
    $clientSecret = "iTDTkMJmcGMZxZKZCQvNby4aSGMG4rYJD77";


    $accessToken = (new ClientCredentialsGrantRequest($clientId, $clientSecret))->getTokens()->{"access_token"};

    echo $accessToken;


    $resonse = \Zara4\API\ImageProcessing\Image::optimiseImageFromFile("test-images/Ataraxia.jpg");

    var_dump($resonse);

    //$this->assertTrue(true);
  }


}