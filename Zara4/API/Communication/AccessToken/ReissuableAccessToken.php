<?php namespace Zara4\API\Communication\AccessToken;

use Zara4\API\Communication\Grant\ClientCredentialsGrantRequest;
use Zara4\API\Communication\Util;


class ReissuableAccessToken extends AccessToken {

  private $scopes = [];


  public function __construct($clientId, $clientSecret, $accessToken, $expiresAt, array $scopes = []) {
    parent::__construct($clientId, $clientSecret, $accessToken, $expiresAt);
    $this->scopes = $scopes;
  }


  /**
   * Refresh this AccessToken
   */
  public function refresh() {
    $grant = new ClientCredentialsGrantRequest($this->clientId, $this->clientSecret, $this->scopes);
    $tokens = $grant->getTokens();

    $this->accessToken = $tokens->{"access_token"};
    $this->expiresAt = Util::calculateExpiryTime($tokens->{"expires_in"});
  }

} 