<?php namespace Zara4\API\Communication;


class Config {

  const VERSION    = '1.2.3';
  const USER_AGENT = 'Zara 4 PHP-SDK, Version-1.2.3';

  const PRODUCTION_API_ENDPOINT = "https://api.zara4.com";
  const DEVELOPMENT_API_ENDPOINT = "http://api.zara4.dev";

  public static $BASE_URL = self::PRODUCTION_API_ENDPOINT;


  // --- --- --- --- ---


  /**
   * Get the base url.
   *
   * @return string
   */
  public static function BASE_URL() {
    return self::$BASE_URL;
  }


  /**
   * Set the base url
   *
   * @param $baseUrl
   */
  public static function setBaseUrl($baseUrl) {
    self::$BASE_URL = $baseUrl;
  }


  /**
   * Configure production mode.
   */
  public static function enterProductionMode() {
    self::setBaseUrl(self::PRODUCTION_API_ENDPOINT);
  }


  /**
   * Configure development mode.
   */
  public static function enterDevelopmentMode() {
    self::setBaseUrl(self::DEVELOPMENT_API_ENDPOINT);
  }





} 