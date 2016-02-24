<?php namespace Zara4\API\Communication\Authentication;

use Zara4\API\Communication\AccessToken\AccessToken;
use Zara4\API\Communication\AccessToken\ReissuableAccessToken;
use Zara4\API\Communication\Grant\ClientCredentialsGrantRequest;
use Zara4\API\Communication\Util;


class ApplicationAuthenticator extends Authenticator {

  /**
   * Get an AccessToken for use when communicating with the Zara 4 API service.
   *
   * @return ReissuableAccessToken
   */
  public function acquireAccessToken() {
    $grant = new ClientCredentialsGrantRequest($this->clientId, $this->clientSecret, $this->scopes);
    $tokens = $grant->getTokens();

    $accessToken = $tokens->{"access_token"};
    $expiresAt = Util::calculateExpiryTime($tokens->{"expires_in"});

    return new ReissuableAccessToken($this->clientId, $this->clientSecret, $accessToken, $expiresAt, $this->scopes);
  }

}