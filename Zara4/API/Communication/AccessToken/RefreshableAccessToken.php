<?php namespace Zara4\API\Communication\AccessToken;


use Zara4\API\Communication\Grant\RefreshTokenGrant;
use Zara4\API\Communication\Util;

class RefreshableAccessToken extends AccessToken {

  protected $refreshToken;


  public function __construct($clientId, $clientSecret, $accessToken, $expiresAt, $refreshToken) {
    parent::__construct($clientId, $clientSecret, $accessToken, $expiresAt);
    $this->refreshToken = $refreshToken;
  }


  /**
   * Refresh this AccessToken
   */
  public function refresh() {
    $grant = new RefreshTokenGrant($this->clientId, $this->clientSecret, $this->refreshToken);
    $tokens = $grant->getTokens();

    $this->accessToken = $tokens->{"access_token"};
    $this->expiresAt = Util::calculateExpiryTime($tokens->{"expires_in"});
    $this->refreshToken = $tokens->{"refresh_token"};
  }

} 