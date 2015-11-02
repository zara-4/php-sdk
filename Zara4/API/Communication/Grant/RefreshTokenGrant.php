<?php namespace Zara4\API\Communication\Grant;


class RefreshTokenGrant extends GrantRequest {

  protected $grantType = "refresh_token";
  protected $refreshToken;

  public function __construct($clientId, $clientSecret, $refreshToken, $scopes = []) {
    $this->refreshToken = $refreshToken;
    parent::__construct($clientId, $clientSecret, $scopes);
  }

} 