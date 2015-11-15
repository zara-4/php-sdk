<?php namespace Zara4\API\Communication;


class Config {

  private static $BASE_URL = "https://zara4.com";


  public static function BASE_URL() {
    return self::$BASE_URL;
  }


  public static function set_BASE_URL($baseUrl) {
    self::$BASE_URL = $baseUrl;
  }

} 