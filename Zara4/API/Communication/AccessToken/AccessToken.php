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
   * Get the token.
   *
   * @return String
   */
  public function token() {
    if($this->hasExpired()) {
      $this->refresh();
    }
    return $this->accessToken;
  }


  /**
   * Represent this AccessToken as a String.
   *
   * @return String
   */
  public function __toString() {
    return $this->token();
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