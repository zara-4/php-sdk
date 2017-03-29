<?php namespace Zara4\API\Communication;


class WebhookLimitReachedException extends Exception {

  public $maximumNumberOfWebhooks;

  public function __construct($maximumNumberOfWebhooks) {
    $this->maximumNumberOfWebhooks = $maximumNumberOfWebhooks;
  }

} 