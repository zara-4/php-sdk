<?php namespace Zara4\API\Communication;


class Config {

  const VERSION    = '1.1.0';
  const USER_AGENT = 'Zara 4 PHP-SDK, Version-1.1.0';

  const PRODUCTION_API_ENDPOINT = "https://api.zara4.com";
  const DEVELOPMENT_API_ENDPOINT = "http://api.zara4.dev";

  private static $BASE_URL = self::PRODUCTION_API_ENDPOINT;


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
   * Configure production mode.
   */
  public static function enterProductionMode() {
    self::$BASE_URL = self::PRODUCTION_API_ENDPOINT;
  }


  /**
   * Configure development mode.
   */
  public static function enterDevelopmentMode() {
    self::$BASE_URL = self::DEVELOPMENT_API_ENDPOINT;
  }


} 