<?php namespace Zara4\API\Communication;

use GuzzleHttp\Client;


class OAuth {


  /**
   * Get a access token for the given ClientId and ClientSecret.
   *
   * @param $clientId
   * @param $clientSecret
   * @return array
   */
  public static function requestAccessToken($clientId, $clientSecret) {

    $url = Util::url("/oauth/access_token");

    $client = new Client();
    $res = $client->request("POST", $url, [
      "json" => [
        "grant_type" => "client_credentials",
        "client_id" => $clientId,
        "client_secret" => $clientSecret,
        "scope" => "image-processing",
      ],
    ]);

    return json_decode($res->getBody());
  }

} 