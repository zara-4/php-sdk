<?php namespace Zara4\API\Communication\AccessToken;


abstract class AccessToken {

  protected $clientId;
  protected $clientSecret;
  protected $accessToken;
  protected $expiresAt;


  public function __construct($clientId, $clientSecret, $accessToken, $expiresAt) {
    $this->clientId = $clientId;
    $this->clientSecret = $clientSecret;
    $this->accessToken = $accessToken;
    $this->expiresAt = $expiresAt;
  }


  /**
   * Represent this AccessToken as a String.
   *
   * @return String
   */
  public function __toString() {
    return $this->accessToken;
  }


  /**
   * Refresh this AccessToken.
   *
   * @return void
   */
  public abstract function refresh();


  /**
   * Has this AccessToken expired?
   *
   * @return bool
   */
  public function hasExpired() {
    return time() > $this->expiresAt;
  }


} 