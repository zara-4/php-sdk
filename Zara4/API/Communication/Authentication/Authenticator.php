<?php namespace Zara4\API\Communication\Authentication;

use Zara4\API\Communication\AccessToken\AccessToken;


abstract class Authenticator {

  protected $clientId;
  protected $clientSecret;
  protected $scopes = [];


  public function __construct($clientId, $clientSecret) {
    $this->clientId = $clientId;
    $this->clientSecret = $clientSecret;
  }


  /**
   * Get an AccessToken for use when communicating with the Zara 4 API service.
   *
   * @return AccessToken
   */
  public abstract function acquireAccessToken();



    /**
     * Add image processing to the Authenticator scope.
     *
     * @return $this
     */
  public function withImageProcessing() {
    array_push($this->scopes, "image-processing");
    return $this;
  }


  /**
   * Add usage to the Authenticator scope.
   *
   * @return $this
   */
  public function withUsage() {
    array_push($this->scopes, "usage");
    return $this;
  }


} 