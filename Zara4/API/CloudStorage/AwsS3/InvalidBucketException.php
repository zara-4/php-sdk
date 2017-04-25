<?php namespace Zara4\API\CloudStorage\AwsS3;


class InvalidBucketException extends Exception {

  private $bucket;

  public function __construct($bucket) {
    $this->bucket = $bucket;
  }


  public function bucket() {
    return $this->bucket;
  }

}