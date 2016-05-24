<?php namespace Zara4\API\Communication;


class BadPaymentException extends Exception {

  public function __construct($message) {
    parent::__construct($message);
  }

} 