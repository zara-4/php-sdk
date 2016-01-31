<?php namespace Zara4\API\ImageProcessing;


abstract class Request {

  public $optimisationMode;
  public $outputFormat;
  public $resizeMode;
  public $colourEnhancement;


  /**
   * Construct a new image processing Request with the given options.
   *
   * @param string $optimisationMode
   * @param string $outputFormat
   * @param string $resizeMode
   * @param string $colourEnhancement
   */
  public function __construct(
    $optimisationMode = OptimisationMode::COMPROMISE, $outputFormat = OutputFormat::MATCH,
    $resizeMode = ResizeMode::NONE, $colourEnhancement = ColourEnhancement::NONE
  ) {
    $this->optimisationMode = $optimisationMode;
    $this->outputFormat = $outputFormat;
    $this->resizeMode = $resizeMode;
    $this->colourEnhancement = $colourEnhancement;
  }


  /**
   * @return string[]
   */
  public function generateFormData() {
    return [
      "optimisation-mode"   => $this->optimisationMode,
      "output-format"       => $this->outputFormat,
      "resize-mode"         => $this->resizeMode,
      "colour-enhancement"  => $this->colourEnhancement,
    ];
  }


}