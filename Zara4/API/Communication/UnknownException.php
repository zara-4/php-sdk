<?php namespace Zara4\API\Communication;


class UnknownException extends Exception {

  private $type;
  private $description;
  private $data;


  public function __construct($type = null, $description = null, $data = null) {
    $this->type = $type;
    $this->description = $description;
    $this->data = $data;
  }

} 