<?php namespace Zara4\API\ImageProcessing;


class Request {

  private $id;
  private $imageName;
  private $originalFileSize;


  public function __construct($id, $imageName, $originalFileSize) {
    $this->id = $id;
    $this->imageName = $imageName;
    $this->originalFileSize = $originalFileSize;
  }


  public function id() {
    return $this->id;
  }


  public function imageName() {
    return $this->imageName;
  }


  public function originalFileSize() {
    return $this->originalFileSize;
  }

} 