<?php namespace Zara4\API\ImageProcessing;

use Zara4\API\Communication\Util;


class Image {



  private static function optimiseImage($data) {
    $url = Util::url("/api/image-processing/optimise");
    return Util::post($url, $data);
  }



  public static function optimiseImageFromUrl($url, $accessToken = null) {

  }


/*
 *       file.additionalData["output-format"] = currentOutputFormat();
      file.additionalData["optimisation-mode"] = currentOptimisationMode();
      file.additionalData["width"] = currentResizeWidth();
      file.additionalData["height"] = currentResizeHeight();
      file.additionalData["resize-mode"] = currentResizeMode();
 */


  /**
   * Optimise the image at the given file path.
   *
   * @param $filePath
   * @param string $outputFormat
   * @param string $optimisationMode
   * @param string $resizeMode
   * @param null $width
   * @param null $height
   * @param null|string $accessToken
   * @return array
   */
  public static function optimiseImageFromFile(
    $filePath, $outputFormat = "auto", $optimisationMode = "highest", $resizeMode = "none",
    $width = null, $height = null, $accessToken = null
  ) {

    //
    // Construct data containing file to be processed.
    //
    $data = [
      "multipart" => [
        [
          "name"     => "file",
          "contents" => fopen($filePath, "r"),
          "filename" => "test.jpg",
        ],
        [
          "name"     => "output-format",
          "contents" => $outputFormat,
        ],
        [
          "name"     => "optimisation-mode",
          "contents" => $optimisationMode,
        ],
        [
          "name"     => "resize-mode",
          "contents" => $resizeMode,
        ],
        [
          "name"     => "output-format",
          "contents" => $outputFormat,
        ],
      ]
    ];

    //
    // Attach dimensions
    //
    if($width) {
      $data["multipart"][] = [
        "name"     => "width",
        "contents" => $width
      ];
    }
    if($height) {
      $data["multipart"][] = [
        "name"     => "height",
        "contents" => $height
      ];
    }

    //
    // If we have an access_token attach it to the request (otherwise API will perform anonymous request).
    //
    if($accessToken) {
      $data["multipart"][] = [
        "name"     => "access_token",
        "contents" => $accessToken
      ];
    }

    //
    // Execute
    //
    return self::optimiseImage($data);
  }


}