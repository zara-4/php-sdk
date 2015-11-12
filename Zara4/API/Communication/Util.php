<?php namespace Zara4\API\Communication;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Util {

  const BASE_URL = "https://zara4.com";


  /**
   * Get the url to the given path.
   *
   * @param $path
   * @return string
   */
  public static function url($path) {
    return self::BASE_URL . $path;
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


} 