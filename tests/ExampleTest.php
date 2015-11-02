<?php

class ExampleTest extends \PHPUnit_Framework_TestCase {


  public function testExample() {

    $clientId = "5ePp9VKQfnptyWbGna9lTu3i5YgLGn8r8JI";
    $clientSecret = "BtFjnmQkW0icp5SHPmIdMMV2eQUdyOx6bvZ";


    $accessToken = \Zara4\API\Communication\OAuth::requestAccessToken($clientId, $clientSecret)->{"access_token"};

    echo $accessToken;


    $resonse = \Zara4\API\ImageProcessing\Image::optimiseImageFromFile("test-images/Ataraxia.jpg");

    var_dump($resonse);

    //$this->assertTrue(true);
  }


}