<?php namespace Zara4\API\ImageProcessing;


use GuzzleHttp\Post\PostFile;

class LocalImageRequest extends Request {

  /** @var string $pathToImage */
  protected $pathToImage;


  /**
   * Construct a new LocalImageRequest to process the given path.
   *
   * @param string $pathToImage
   * @param string $optimisationMode
   * @param string $outputFormat
   * @param string $resizeMode
   * @param int|null|string $colourEnhancement
   * @param int $width
   * @param int $height
   * @param bool $maintainExif
   */
  public function __construct(
    $pathToImage,
    $optimisationMode = OptimisationMode::COMPROMISE, $outputFormat = OutputFormat::MATCH,
    $resizeMode = ResizeMode::NONE, $colourEnhancement = ColourEnhancement::NONE, $width = null, $height = null,
    $maintainExif = false
  ) {
    $this->pathToImage = $pathToImage;
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
    $data["file"] = new PostFile('file', fopen($this->pathToImage, 'r'));
    return $data;
  }

}