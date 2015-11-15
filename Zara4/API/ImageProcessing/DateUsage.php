<?php namespace Zara4\API\ImageProcessing;


class DateUsage {

  private $date;
  private $requests;


  /**
   * @param $date
   * @param Request[] $requests
   */
  public function __construct($date, array $requests) {
    $this->date = $date;
    $this->requests = $requests;
  }


  /**
   * The number of Requests completed.
   *
   * @return int
   */
  public function numberOfRequests() {
    return count($this->requests);
  }

} 