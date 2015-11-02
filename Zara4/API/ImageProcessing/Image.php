<?php namespace Zara4\API\ImageProcessing;

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
   * @return array
   */
  public static function optimiseImageFromFile($filePath, array $params = []) {

    //
    // Construct data containing file to be processed and params.
    //
    $data = ["multipart" => [
      [
        "name"     => "file",
        "contents" => fopen($filePath, "r"),
        "filename" => "test.jpg",
      ]
    ]];
    foreach($params as $key => $value) {
      $data["multipart"][] = [
        "name"     => $key,
        "contents" => $value
      ];
    }

    //
    // Execute
    //
    return self::optimiseImage($data);
  }


}