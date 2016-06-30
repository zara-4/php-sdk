<?php namespace Zara4\API\Communication;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Zara4\API\ImageProcessing\AnonymousUserQuotaLimitException;
use Zara4\API\ImageProcessing\EmailNotVerifiedException;
use Zara4\API\ImageProcessing\QuotaLimitException;
use Zara4\API\ImageProcessing\RegisteredUserQuotaLimitException;


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
   * @throws Exception
   * @throws \Zara4\API\ImageProcessing\QuotaLimitException
   * @throws AccessDeniedException
   * @return array
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

      // Bad payment
      if($responseData->{"error"} == "bad_payment") {
        throw new BadPaymentException($responseData->{"error_description"});
      }

      if($responseData && $responseData->{"error"} == "quota_limit") {
        $data = $responseData->{"data"};
        if($data->{'action'} == 'registration-required') {
          throw new AnonymousUserQuotaLimitException();
        } else {
          throw new RegisteredUserQuotaLimitException();
        }
      }

      if($responseData->{"error"} == "user_email_not_verified") {
        throw new EmailNotVerifiedException($responseData->{"error_description"});
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
      if($responseData && $responseData->{"error"} == "invalid_scope") {
        throw new AccessDeniedException("The client credentials are not authorised to perform this action. Scope error.");
      }

      // Bad payment
      if($responseData->{"error"} == "bad_payment") {
        throw new BadPaymentException($responseData->{"error_description"});
      }

      if($responseData && $responseData->{"error"} == "quota_limit") {
        $data = $responseData->{"data"};
        if($data->{'action'} == 'registration-required') {
          throw new AnonymousUserQuotaLimitException();
        } else {
          throw new RegisteredUserQuotaLimitException();
        }
      }

      if($responseData->{"error"} == "user_email_not_verified") {
        throw new EmailNotVerifiedException($responseData->{"error_description"});
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


  /**
   * Get the ip address from the current request.
   *
   * @return String
   */
  public static function currentIpAddress() {

    //
    // Just get the headers if we can or else use the SERVER global
    //
    if(function_exists('apache_request_headers')) {
      $headers = apache_request_headers();
    } else {
      $headers = $_SERVER;
    }

    //
    // Get the forwarded IP if it exists
    //
    if(
      array_key_exists('X-Forwarded-For', $headers) &&
      filter_var($headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)
    ) {
      $the_ip = $headers['X-Forwarded-For'];
    }

    elseif(
      array_key_exists('HTTP_X_FORWARDED_FOR', $headers ) &&
      filter_var($headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)
    ) {
      $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
    }

    else {
      $the_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    return $the_ip;
  }


} 