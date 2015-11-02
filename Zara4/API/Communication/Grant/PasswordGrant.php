<?php namespace Zara4\API\Communication\Grant;


class PasswordGrant extends GrantRequest {

  protected $grantType = "password";
  protected $username;
  protected $password;


  public function __construct($clientId, $clientSecret, $username, $password, $scopes = []) {
    $this->username = $username;
    $this->password = $password;
    parent::__construct($clientId, $clientSecret, $scopes);
  }


  protected function data() {
    return array_merge(parent::data(), [
      "username" => $this->username,
      "password" => $this->password,
    ]);
  }


} 