<?php namespace Zara4\API\Auth\Register\EmailAddress;

class DomainIsBlacklistedException extends Exception {

  public $domain;


  public function __construct($domain) {
    $this->domain = $domain;
  }

} 