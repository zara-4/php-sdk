<?php namespace Zara4\API\ImageProcessing;


class ProcessedImage implements \JsonSerializable {

  /** @var Request $request */
  protected $request;

  /** @var string $requestId */
  protected $requestId;

  /** @var string[] $fileUrls */
  public $fileUrls;

  /** @var int $originalFileSize */
  protected $originalFileSize;

  /** @var int $compressedFileSize */
  protected $compressedFileSize;


  /**
   * Construct a new ProcessedImage.
   *
   * @param Request $request
   * @param string $requestId
   * @param string[] $fileUrls
   * @param int $originalFileSize
   * @param int $compressedFileSize
   */
  public function __construct(
    Request $request, $requestId, array $fileUrls, $originalFileSize, $compressedFileSize
  ) {
    $this->request = $request;
    $this->requestId = $requestId;
    $this->fileUrls = $fileUrls;
    $this->originalFileSize = $originalFileSize;
    $this->compressedFileSize = $compressedFileSize;
  }


  /**
   * Get the file size (in bytes) of the original uncompressed image.
   *
   * @return int
   */
  public function originalFileSize() {
    return $this->originalFileSize;
  }


  /**
   * Get the file size (in bytes) of the compressed image.
   *
   * @return int
   */
  public function compressedFileSize() {
    return $this->compressedFileSize;
  }


  /**
   * Get the ratio by which the image has been compressed.
   *
   * @return float
   */
  public function compressionRatio() {
    return $this->compressedFileSize / $this->originalFileSize;
  }


  /**
   * The percentage compression achieved.
   *
   * @return float
   */
  public function percentageSaving() {
    return (1 - $this->compressionRatio()) * 100;
  }


  /**
   * Was the original image compressed?
   *
   * @return bool
   */
  public function compressionWasAchieved() {
    return $this->compressionRatio() < 1;
  }


  /**
   * (PHP 5 >= 5.4.0)
   *
   * Specify data which should be serialized to JSON
   *
   * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
   *
   * @return mixed data which can be serialized by <b>json_encode</b>,
   * which is a value of any type other than a resource.
   */
  public function jsonSerialize() {
    return [
      'request-id'            => $this->requestId,
      'file-urls'             => $this->fileUrls,
      'original-file-size'    => $this->originalFileSize,
      'compressed-file-size'  => $this->compressedFileSize,
      'percentage-saving'     => $this->percentageSaving(),
      'compression-ratio'     => $this->compressionRatio(),
    ];
  }

}