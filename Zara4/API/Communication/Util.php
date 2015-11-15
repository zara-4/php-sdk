<?php namespace Zara4\API\Communication;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Util {

  /**
   * Get the url to the given path.
   *
   * @param $path
   * @return string
   */
  public static function url($path) {
    return Config::BASE_URL() . $path;
  }


  /**
   * GET the given $data to the given $url.
   *
   * @param $url
   * @param $data
   * @return array
   * @throws Exception
   * @throws AccessDeniedException
   */
  public static function get($url, $data) {

    //
    // Attempt Request
    //
    try {
      $client = new Client();
      $res = $client->get($url, $data);
      return json_decode($res->getBody());
    }

      //
      // Error Handling
      //
    catch(RequestException $e) {
      $responseData = json_decode($e->getResponse()->getBody());

      // Client does not have scope permission
      if($responseData->{"error"} == "invalid_scope") {
        throw new AccessDeniedException("The client credentials are not authorised to perform this action. Scope error.");
      }

      // Generic error
      throw new Exception($responseData->{"error_description"});
    }
  }


  /**
   * Post the given $data to the given $url.
   *
   * @param $url
   * @param $data
   * @return array
   * @throws Exception
   * @throws AccessDeniedException
   */
  public static function post($url, $data) {

    //
    // Attempt Request
    //
    try {
      $client = new Client();
      $res = $client->post($url, $data);
      return json_decode($res->getBody());
    }

    //
    // Error Handling
    //
    catch(RequestException $e) {
      $responseData = json_decode($e->getResponse()->getBody());

      // Client does not have scope permission
      if($responseData->{"error"} == "invalid_scope") {
        throw new AccessDeniedException("The client credentials are not authorised to perform this action. Scope error.");
      }

      // Generic error
      throw new Exception($responseData->{"error_description"});
    }
  }




  /**
   * Calculate the expiry time from the given lifetime time.
   *
   * @param int $expiresIn
   * @return int
   */
  public static function calculateExpiryTime($expiresIn) {
    // Give 60 second buffer for expiry
    $expiresIn = intval($expiresIn) - 60;
    return time() + $expiresIn;
  }



} 