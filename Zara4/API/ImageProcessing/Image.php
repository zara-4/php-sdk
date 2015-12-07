<?php namespace Zara4\API\ImageProcessing;

use GuzzleHttp\Post\PostFile;
use Zara4\API\Communication\Util;


class Image {



  private static function optimiseImage($data) {
    $url = Util::url("/api/image-processing/optimise");
    return Util::post($url, $data);
  }



  public static function optimiseImageFromUrl($url, array $params = []) {

  }


  /**
   * Optimise the image at the given file path.
   *
   * @param $filePath
   * @param array $params
   * @param null $forwardForIp
   * @return array
   */
  public static function optimiseImageFromFile($filePath, array $params = [], $forwardForIp = null) {

    //
    // Construct data containing file to be processed and params.
    //
    $data = ["body" => [
      "file" => new PostFile('file', fopen($filePath, 'r')),

      //
      // Works for Guzzle 6
      //
      //[
      //  "name"     => "file",
      //  "contents" => fopen($filePath, "r"),
      //  "filename" => "test.jpg",
      //]
    ]];
    foreach($params as $key => $value) {
      $data["body"][$key] = $value;

      //
      // Works for Guzzle 6
      //
      //$data["body"][] = [
      //  "name"     => $key,
      //  "contents" => $value
      //];
    }


    //
    // NOTE: This will be ignored for all API credentials (except trusted applications) to prevent ip hoaxing
    //
    if($forwardForIp) {
      $data["headers"] = [
        "Z4-Connecting-IP" => $forwardForIp,
      ];
    }


    //
    // Execute
    //
    return self::optimiseImage($data);
  }


}