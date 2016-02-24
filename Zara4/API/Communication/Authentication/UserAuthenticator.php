<?php namespace Zara4\API\Communication\Authentication;

use Zara4\API\Communication\AccessToken\AccessToken;
use Zara4\API\Communication\AccessToken\RefreshableAccessToken;
use Zara4\API\Communication\Grant\PasswordGrant;
use Zara4\API\Communication\Util;


class UserAuthenticator extends Authenticator {

  private $username;
  private $password;


  public function __construct($clientId, $clientSecret, $username, $password) {
    parent::__construct($clientId, $clientSecret);
    $this->username = $username;
    $this->password = $password;
  }


  /**
   * Get an AccessToken for use when communicating with the Zara 4 API service.
   *
   * @return RefreshableAccessToken
   */
  public function acquireAccessToken() {
    $grant = new PasswordGrant($this->clientId, $this->clientSecret, $this->username, $this->password, $this->scopes);
    $tokens = $grant->getTokens();

    $accessToken = $tokens->{"access_token"};
    $refreshToken = $tokens->{"refresh_token"};
    $expiresAt = Util::calculateExpiryTime($tokens->{"expires_in"});

    return new RefreshableAccessToken($this->clientId, $this->clientSecret, $accessToken, $expiresAt, $refreshToken);
  }

}