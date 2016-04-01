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
   * Add scope to this Authenticator.
   *
   * @param $scope
   * @return $this
   */
  public function addScope($scope) {
    array_push($this->scopes, $scope);
    return $this;
  }


  /**
   * Add image processing to the Authenticator scope.
   *
   * @return $this
   */
  public function withImageProcessing() {
    return $this->addScope('image-processing');
  }


  /**
   * Add usage to the Authenticator scope.
   *
   * @return $this
   */
  public function withUsage() {
    return $this->addScope('usage');
  }


} 