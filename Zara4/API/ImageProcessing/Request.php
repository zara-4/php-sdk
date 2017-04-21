<?php namespace Zara4\API\ImageProcessing;


abstract class Request {

  public $optimisationMode;
  public $outputFormat;
  public $resizeMode;
  public $colourEnhancement;
  public $width;
  public $height;
  public $maintainExif;

  private $cloudStorageDestinationId = null;
  private $cloudStorageDestinationFileId = null;
  private $cloudStorageDestinationParentId = null;


  /**
   * Construct a new image processing Request with the given options.
   *
   * @param string $optimisationMode
   * @param string $outputFormat
   * @param string $resizeMode
   * @param string $colourEnhancement
   * @param int $width
   * @param int $height
   * @param bool $maintainExif
   */
  public function __construct(
    $optimisationMode = OptimisationMode::COMPROMISE, $outputFormat = OutputFormat::MATCH,
    $resizeMode = ResizeMode::NONE, $colourEnhancement = ColourEnhancement::NONE, $width = null, $height = null,
    $maintainExif = false
  ) {
    $this->optimisationMode   = $optimisationMode;
    $this->outputFormat       = $outputFormat;
    $this->resizeMode         = $resizeMode;
    $this->colourEnhancement  = $colourEnhancement;
    $this->width              = $width;
    $this->height             = $height;
    $this->maintainExif       = $maintainExif;
  }


  /**
   * @return string[]
   */
  public function generateFormData() {
    $data = [
      'optimisation-mode'   => $this->optimisationMode,
      'output-format'       => $this->outputFormat,
      'resize-mode'         => $this->resizeMode,
      'colour-enhancement'  => $this->colourEnhancement,
      'width'               => $this->width,
      'height'              => $this->height,
      'maintain-exif'       => $this->maintainExif,
    ];

    //
    // Cloud Upload
    //
    $destination = [
      'drive-id'  => $this->cloudStorageDestinationId,
      'file-id'   => $this->cloudStorageDestinationFileId,
    ];
    if ($this->cloudStorageDestinationParentId) {
      $destination['parent-id'] = $this->cloudStorageDestinationParentId;
    }
    if ($this->cloudStorageDestinationId && $this->cloudStorageDestinationFileId) {
      $data['cloud'] = ['destination' => $destination];
    }

    return $data;
  }


  /**
   * @param $cloudStorageLocationId
   * @param $cloudStorageLocationFilePath
   * @param $cloudStorageLocationParentId
   */
  public function uploadToCloud(
    $cloudStorageLocationId, $cloudStorageLocationFilePath, $cloudStorageLocationParentId = null
  ) {
    $this->cloudStorageDestinationId = $cloudStorageLocationId;
    $this->cloudStorageDestinationFileId = $cloudStorageLocationFilePath;
    $this->cloudStorageDestinationParentId = $cloudStorageLocationParentId;
  }


}