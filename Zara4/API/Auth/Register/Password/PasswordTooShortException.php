<?php namespace Zara4\API\Auth\Register\Password;

class PasswordTooShortException extends Exception {

  public $minimumLength;


  public function __construct($minimumLength) {
    $this->minimumLength = $minimumLength;
  }

}