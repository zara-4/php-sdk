<?php namespace Zara4\API\ImageProcessing;

use Zara4\API\Communication\Util;


class Usage {


  public static function currentBillingUsage($accessToken) {

    $url = Util::url("/api/usage/current-billing-period");
    $data = ["query" => [
      "access_token" => $accessToken,
    ]];

    $responseData = Util::get($url, $data);
    $dayData = (array)($responseData->{"day-data"});

    return array_map(function($dateData) {
      return $dateData->{"count"};
    }, $dayData);
  }


}