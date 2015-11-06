<?php namespace Zara4\API\Communication\Grant;

use Zara4\API\Communication\Util;


abstract class GrantRequest {

  protected $grantType;
  protected $scopes;
  protected $clientId;
  protected $clientSecret;


  public function __construct($clientId, $clientSecret, $scopes = []) {
    $this->clientId = $clientId;
    $this->clientSecret = $clientSecret;
    $this->scopes = $scopes;
  }


  /**
   * @return array
   */
  public function getTokens() {
    return Util::post(
      Util::url("/oauth/access_token"),
      ["body" => $this->data()]
    );
  }



  protected function data() {
    return [
      "grant_type"    => $this->grantType,
      "client_id"     => $this->clientId,
      "client_secret" => $this->clientSecret,
      "scope"         => implode(",", array_unique($this->scopes)),
    ];
  }



  /**
   * Add image processing to the request scope.
   *
   * @return $this
   */
  public function withImageProcessing() {
    array_push($this->scopes, "image-processing");
    return $this;
  }


  /**
   * Add usage to the request scope.
   *
   * @return $this
   */
  public function withUsage() {
    array_push($this->scopes, "usage");
    return $this;
  }

} 