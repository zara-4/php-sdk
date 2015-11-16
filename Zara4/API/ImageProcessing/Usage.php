<?php namespace Zara4\API\ImageProcessing;

use Zara4\API\Communication\Util;


class Usage {


  public static function cumulativeUsageForCurrentBillingUsage($accessToken) {

    $url = Util::url("/api/usage/image-processing/cumulative-count/current-billing-period");
    $data = ["query" => [
      "access_token" => $accessToken,
    ]];

    $responseData = Util::get($url, $data);
    return (array)($responseData->{"day-data"});
  }


}