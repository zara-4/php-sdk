<?php namespace Zara4\API\ImageProcessing;

use Zara4\API\Communication\Util;


class Usage {


  public static function cumulativeUsageForCurrentBillingUsage($accessToken) {

    $url = Util::url("/v1/usage/image-processing/cumulative-count/current-billing-period");
    $data = ["query" => [
      "access_token" => $accessToken,
    ]];

    $responseData = Util::get($url, $data);

    $personalDayData = (array)$responseData->{"day-data"};
    ksort($personalDayData);

    $response = [
      "quota" => $responseData->{"quota"},
      "personal-day-data" => $personalDayData,
    ];


    //
    // Add team data
    //
    if(isset($responseData->{"team-day-data"})) {
      $teamDayData = (array)$responseData->{"team-day-data"};
      ksort($teamDayData);
      $response["team-day-data"] = $teamDayData;
    }


    return $response;
  }


}