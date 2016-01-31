<?php namespace Zara4\API\ImageProcessing;


class RemoteImageRequest extends Request {

  /** @var string $url */
  protected $url;


  /**
   * Construct a new RemoteImageRequest to process the given url.
   *
   * @param string $url
   * @param string $optimisationMode
   * @param string $outputFormat
   * @param string $resizeMode
   * @param string $colourEnhancement
   */
  public function __construct(
    $url,
    $optimisationMode = OptimisationMode::COMPROMISE, $outputFormat = OutputFormat::MATCH,
    $resizeMode = ResizeMode::NONE, $colourEnhancement = ColourEnhancement::NONE
  ) {
    $this->url = $url;
    parent::__construct($optimisationMode, $outputFormat, $resizeMode, $colourEnhancement);
  }




  /**
   *
   * @return \string[]
   */
  public function generateFormData() {
    $data = parent::generateFormData();
    $data["url"] = $this->url;
    return $data;
  }

} 