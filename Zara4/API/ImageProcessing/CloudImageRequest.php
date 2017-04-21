<?php namespace Zara4\API\ImageProcessing;


class CloudImageRequest extends Request {

  /** @var string $cloudStorageLocationId */
  protected $cloudStorageLocationId;

  /** @var string $cloudStorageLocationFilePath */
  protected $cloudStorageLocationFilePath;


  /**
   * Construct a new LocalImageRequest to process the given path.
   *
   * @param string $cloudStorageLocationId
   * @param string $cloudStorageLocationFilePath
   * @param string $optimisationMode
   * @param string $outputFormat
   * @param int|null|string $resizeMode
   * @param int|null|string $colourEnhancement
   * @param int $width
   * @param int $height
   * @param bool $maintainExif
   */
  public function __construct(
    $cloudStorageLocationId, $cloudStorageLocationFilePath,
    $optimisationMode = OptimisationMode::COMPROMISE, $outputFormat = OutputFormat::MATCH,
    $resizeMode = ResizeMode::NONE, $colourEnhancement = ColourEnhancement::NONE, $width = null, $height = null,
    $maintainExif = false
  ) {
    $this->cloudStorageLocationId = $cloudStorageLocationId;
    $this->cloudStorageLocationFilePath = $cloudStorageLocationFilePath;
    parent::__construct(
      $optimisationMode, $outputFormat, $resizeMode, $colourEnhancement, $width, $height, $maintainExif
    );
  }


  /**
   *
   * @return \string[]
   */
  public function generateFormData() {
    $data = parent::generateFormData();

    //
    // Add Cloud Source
    //
    $cloud = array_key_exists('cloud', $data) ? $data['cloud'] : [];
    $cloud = array_merge([
      'source' => [
        'drive-id'  => $this->cloudStorageLocationId,
        'file-id'   => $this->cloudStorageLocationFilePath,
      ],
    ], $cloud);
    $data['cloud'] = $cloud;


    return $data;
  }

}