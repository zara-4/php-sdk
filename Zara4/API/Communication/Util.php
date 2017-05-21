<?php namespace Zara4\API\Communication;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Zara4\API\Auth\Register\EmailAddress\DomainIsBlacklistedException;
use Zara4\API\Auth\Register\EmailAddress\EmailAlreadyInUseException;
use Zara4\API\Auth\Register\InvalidNameException;
use Zara4\API\Auth\Register\InvalidRecaptchaException;
use Zara4\API\Auth\Register\Password\PasswordTooShortException;
use Zara4\API\CloudStorage\AwsS3\InvalidBucketException;
use Zara4\API\CloudStorage\AwsS3\InvalidCredentialsException;
use Zara4\API\ImageProcessing\AnonymousUserQuotaLimitException;
use Zara4\API\ImageProcessing\EmailNotVerifiedException;
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
   * Handle error
   *
   * @param $responseData
   * @throws AccessDeniedException
   * @throws \Zara4\API\ImageProcessing\EmailNotVerifiedException
   * @throws WebhookLimitReachedException
   * @throws \Zara4\API\ImageProcessing\RegisteredUserQuotaLimitException
   * @throws UnknownException
   * @throws \Zara4\API\ImageProcessing\AnonymousUserQuotaLimitException
   * @throws \Zara4\API\CloudStorage\AwsS3\InvalidCredentialsException
   * @throws \Zara4\API\CloudStorage\AwsS3\InvalidBucketException
   * @throws BadPaymentException
   */
  private static function handleError($responseData) {

    $error = $responseData->{'error'};
    $data = array_key_exists('data', $responseData) ? $responseData->{'data'} : null;

    // --- --- --

    //
    // OAuth
    //

    // Client does not have scope permission
    if ($error == 'invalid_scope') {
      throw new AccessDeniedException('The client credentials are not authorised to perform this action. Scope error.');
    }

    // --- --- ---

    //
    // Image Processing
    //

    // Quota limit
    if ($error == 'quota_limit') {
      $action = $data && array_key_exists('maximum-webhooks', $data)
        ? $data->{'action'} : 'registration-required';
      if ($action == 'registration-required') {
        throw new AnonymousUserQuotaLimitException();
      } else {
        throw new RegisteredUserQuotaLimitException();
      }
    }

    // --- --- ---

    //
    // User
    //

    // Email not verified
    if ($responseData->{'error'} == 'user_email_not_verified') {
      throw new EmailNotVerifiedException($responseData->{'error_description'});
    }

    // --- --- ---

    //
    // Billing
    //

    // Bad payment
    if ($error == 'bad_payment') {
      throw new BadPaymentException($responseData->{'error_description'});
    }

    // --- --- --

    //
    // Webhooks
    //

    // Webhook limit reached
    if ($responseData->{'error'} == 'webhook_limit_reached') {
      $maximumWebhooks = $data && array_key_exists('maximum-webhooks', $data)
        ? $data->{'maximum-webhooks'} : 10;
      throw new WebhookLimitReachedException($maximumWebhooks);
    }

    // --- --- ---

    //
    // Cloud
    //

    // Invalid AWS credentials
    if ($error == 'cloud_aws_invalid_credentials') {
      throw new InvalidCredentialsException();
    }

    // Invalid AWS S3 Bucket
    if ($error == 'cloud_aws_invalid_bucket') {
      $bucket = array_key_exists('bucket', $data) ? $data->{'bucket'} : null;
      throw new InvalidBucketException($bucket);
    }

    // --- --- ---

    //
    // Account Registration
    //

    // Recaptcha invalid
    if ($error == 'auth_register_invalid-recaptcha') {
      throw new InvalidRecaptchaException();
    }

    // Email address domain is blacklisted
    if ($error == 'auth_register_email-domain-blacklisted') {
      $domain = array_key_exists('domain', $data) ? $data->{'domain'} : null;
      throw new DomainIsBlacklistedException($domain);
    }

    // Email address is already in use
    if ($error == 'auth_register_email-already-in-use') {
      throw new EmailAlreadyInUseException();
    }

    // Password too short
    if ($error == 'auth_register_password-too-short') {
      $minimumLength = array_key_exists('minimum-length', $data) ? $data->{'minimum-length'} : null;
      throw new PasswordTooShortException($minimumLength);
    }

    // Name invalid
    if ($error == 'auth_register_invalid-name') {
      throw new InvalidNameException();
    }

    // --- --- ---

    // Generic error
    throw new UnknownException($responseData->{'error_description'});
  }


  /**
   * GET the given $data to the given $url.
   *
   * @param $url
   * @param $data
   * @throws \Zara4\API\Exception
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
    catch (RequestException $e) {
      $responseData = json_decode($e->getResponse()->getBody());
      self::handleError($responseData);
      throw new \Zara4\API\Exception();
    }
  }


  /**
   * Post the given $data to the given $url.
   *
   * @param $url
   * @param $data
   * @throws \Zara4\API\Exception
   * @return array
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
      self::handleError($responseData);
      throw new \Zara4\API\Exception();
    }
  }


  /**
   * @param $url
   * @param $accessToken
   */
  public static function delete($url, $accessToken) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    if ($accessToken != null) {
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer ' . $accessToken)
      );
    }

    $result = curl_exec($ch);
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
    if (function_exists('apache_request_headers')) {
      $headers = apache_request_headers();
    } else {
      $headers = $_SERVER;
    }

    //
    // Get the forwarded IP if it exists
    //
    if (
      array_key_exists('X-Forwarded-For', $headers) &&
      filter_var($headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)
    ) {
      $the_ip = $headers['X-Forwarded-For'];
    }

    elseif (
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