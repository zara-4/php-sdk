<?php namespace Zara4\API;

use Zara4\API\Communication\AccessToken\AccessToken;
use Zara4\API\Communication\Authentication\ApplicationAuthenticator;
use Zara4\API\Communication\Util;
use Zara4\API\ImageProcessing\ProcessedImage;
use Zara4\API\ImageProcessing\Request;


class Client {

  /** @var string $forwardIp */
  private $forwardForIp;

  /** @var AccessToken $accessToken */
  protected $accessToken;

  /** @var String $apiClientId */
  protected $apiClientId;

  /** @var String $apiClientSecret */
  protected $apiClientSecret;


  /**
   * Application authenticated client.
   *
   * @param null $apiClientId
   * @param null $apiClientSecret
   */
  public function __construct($apiClientId = null, $apiClientSecret = null) {
    $this->apiClientId = $apiClientId;
    $this->apiClientSecret = $apiClientSecret;

    if($this->apiClientId && $this->apiClientSecret) {
      $authenticator = new ApplicationAuthenticator($apiClientId, $apiClientSecret);

      $authenticator->withImageProcessing()->withUsage();

      $this->accessToken = $authenticator->acquireAccessToken();
    }
  }


  /**
   * Initialise a new Client from the given API_CLIENT_ID, API_CLIENT_SECRET and AccessToken.
   *
   * @param AccessToken $accessToken
   * @return \Zara4\API\Client
   */
  public static function initialiseFromAccessToken(AccessToken $accessToken) {
    $client = new self();
    $client->accessToken = $accessToken;
    return $client;
  }



  /**
   * Set the ip address to forward for.
   *
   * @param $forwardForIp
   */
  public function setIpToForwardFor($forwardForIp) {
    $this->forwardForIp = $forwardForIp;
  }


  /**
   * @param Request $imageProcessingRequest
   * @return array
   */
  public function processImageRaw(Request $imageProcessingRequest) {
    $url = Util::url("/v1/image-processing/request");

    //
    // Construct data containing url to be processed and params.
    //
    $data = ["body" => []];
    if($this->accessToken) {
      $data["body"]["access-token"] = $this->accessToken->token();
    }

    $params = $imageProcessingRequest->generateFormData();
    foreach($params as $key => $value) {
      $data["body"][$key] = $value;
    }


    //
    // NOTE: This will be ignored for all API credentials (except trusted applications) to prevent ip hoaxing
    //
    if($this->forwardForIp) {
      $data["headers"] = [
        "Z4-Connecting-IP" => $this->forwardForIp,
      ];
    }


    return Util::post($url, $data);
  }


  /**
   * @param Request $imageProcessingRequest
   * @return ProcessedImage
   */
  public function processImage(Request $imageProcessingRequest) {
    $data = $this->processImageRaw($imageProcessingRequest);

    $requestId           = $data->{'request-id'};
    $bytesOriginal       = $data->{'compression'}->{'bytes-original'};
    $bytesCompressed     = $data->{'compression'}->{'bytes-compressed'};
    $generatedImagesUrls = (array)($data->{'generated-images'}->{'urls'});

    return new ProcessedImage(
      $imageProcessingRequest, $requestId, $generatedImagesUrls, $bytesOriginal, $bytesCompressed
    );
  }


  /**
   * Download the given ProcessedImage sand save it to the given path.
   *
   * @param ProcessedImage $processedImage
   * @param string $savePath
   * @throws UnknownServerErrorException
   */
  public function downloadProcessedImage(ProcessedImage $processedImage, $savePath) {
    $url = $processedImage->fileUrls[0];

    if($this->accessToken != null) {
      $url .= "?access_token=" . $this->accessToken->token();
    }

    try {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $data = curl_exec ($ch);
      curl_close ($ch);
      $file = fopen($savePath, "w+");
      fputs($file, $data);
      fclose($file);
    } catch(\Exception $e) {
      throw new UnknownServerErrorException("Failed to retrieve your image");
    }
  }


} 