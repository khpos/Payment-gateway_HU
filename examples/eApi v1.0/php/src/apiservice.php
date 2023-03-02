<?php
namespace Monetplus;
use Monetplus\MipsConnector;
require dirname(__DIR__) . '/vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use JsonMapper\JsonMapperFactory;

class ApiService
{
  private Logger $logger;
  private CryptoService $crypto;

  private \JsonMapper\JsonMapper $mapper;

  private $client;
  function __construct(MipsConnector $connector, CryptoService $cryptoService)
  {
    $this->logger = new Logger('ApiService');
    $this->logger->pushHandler(new StreamHandler('php://stdout', Logger::INFO));
    $this->logger->pushHandler(new StreamHandler('php://stderr', Logger::ERROR));
    $this->crypto = $cryptoService;
    $this->client = $connector;
    $this->mapper = (new JsonMapperFactory())->bestFit();
    $this->mapper->bStrictNullTypes = false;
  }

  function handshake(): bool
  {
    try {
      $response = $this->client->connector()->request('GET', $this->client->baseUrl());
      return true;
    }
    catch (\GuzzleHttp\Exception\RequestException $e) {
      return false;
    }
    catch (\GuzzleHttp\Exception\ConnectException) {
      return false;
    }
  }

  function echoPost(EchoRequest $request): EchoResponse
  {
    $this->crypto->createSignature($request);
    $echoResponse = new EchoResponse();
    try {
      $response = $this->client->connector()->request('POST', $this->client->baseUrl() . "/echo", ['body' => json_encode($request)]);
    }
    catch (\GuzzleHttp\Exception\RequestException $e) {
      if ($e->hasResponse()) {
        $response = $e->getResponse();
      }
      else {
        $this->logger->error($e);
      }
    }
    $this->mapper->mapObject(json_decode($response->getBody()), $echoResponse);
    $this->crypto->verifySignature($echoResponse, $echoResponse->signature);
    return $echoResponse;
  }

  function echoGet(EchoRequest $request): EchoResponse
  {
    $this->crypto->createSignature($request);
    $echoResponse = new EchoResponse();
    try {
      $url = $this->client->baseUrl() . "/echo/" . $request->merchantId . "/" . $request->dttm . "/" . urlencode($request->signature);
      $this->logger->info("echoget", ["url" => $url]);
      $response = $this->client->connector()->request('GET', $url);
    }
    catch (\GuzzleHttp\Exception\RequestException $e) {
      if ($e->hasResponse()) {
        $response = $e->getResponse();
      }
      else {
        $this->logger->error($e);
      }
    }
    $this->mapper->mapObject(json_decode($response->getBody()), $echoResponse);
    $this->crypto->verifySignature($echoResponse, $echoResponse->signature);
    return $echoResponse;
  }

  function googlepayProcess(GooglepayProcessRequest $request): ProcessResponse
  {
    $this->crypto->createSignature($request);
    $processResponse = new ProcessResponse();
    try {
      $response = $this->client->connector()->request('POST', $this->client->baseUrl() . "/googlepay/process", ['body' => json_encode($request)]);
    }
    catch (\GuzzleHttp\Exception\RequestException $e) {
      if ($e->hasResponse()) {
        $response = $e->getResponse();
      }
      else {
        $this->logger->error($e);
      }
    }
    $this->mapper->mapObject(json_decode($response->getBody()), $processResponse);
    $this->crypto->verifySignature($processResponse, $processResponse->signature);
    return $processResponse;
  }

  function googlepayInit(GooglepayInitRequest $request): InitResponse
  {
    $this->crypto->createSignature($request);
    $initResponse = new InitResponse();
    try {
      $response = $this->client->connector()->request('POST', $this->client->baseUrl() . "/googlepay/init", ['body' => json_encode($request)]);
    }
    catch (\GuzzleHttp\Exception\RequestException $e) {
      if ($e->hasResponse()) {
        $response = $e->getResponse();
      }
      else {
        $this->logger->error($e);
      }
    }
    $this->mapper->mapObject(json_decode($response->getBody()), $initResponse);
    $this->crypto->verifySignature($initResponse, $initResponse->signature);
    return $initResponse;
  }
  function googlepayEcho(EchoRequest $request): GooglepayEchoResponse
  {
    $this->crypto->createSignature($request);
    $echoResponse = new GooglepayEchoResponse();
    try {
      $response = $this->client->connector()->request('POST', $this->client->baseUrl() . "/googlepay/echo", ['body' => json_encode($request)]);
    }
    catch (\GuzzleHttp\Exception\RequestException $e) {
      if ($e->hasResponse()) {
        $response = $e->getResponse();
      }
      else {
        $this->logger->error($e);
      }
    }
    $this->mapper->mapObject(json_decode($response->getBody()), $echoResponse);
    $this->crypto->verifySignature($echoResponse, $echoResponse->signature);
    return $echoResponse;
  }

  function applepayProcess(ApplepayProcessRequest $request): ProcessResponse
  {
    $this->crypto->createSignature($request);
    $processResponse = new ProcessResponse();
    try {
      $response = $this->client->connector()->request('POST', $this->client->baseUrl() . "/applepay/process", ['body' => json_encode($request)]);
    }
    catch (\GuzzleHttp\Exception\RequestException $e) {
      if ($e->hasResponse()) {
        $response = $e->getResponse();
      }
      else {
        $this->logger->error($e);
      }
    }
    $this->mapper->mapObject(json_decode($response->getBody()), $processResponse);
    $this->crypto->verifySignature($processResponse, $processResponse->signature);
    return $processResponse;
  }
  function applepayEcho(EchoRequest $request): ApplepayEchoResponse
  {
    $this->crypto->createSignature($request);
    $echoResponse = new ApplepayEchoResponse();
    try {
      $response = $this->client->connector()->request('POST', $this->client->baseUrl() . "/applepay/echo", ['body' => json_encode($request)]);
    }
    catch (\GuzzleHttp\Exception\RequestException $e) {
      if ($e->hasResponse()) {
        $response = $e->getResponse();
      }
      else {
        $this->logger->error($e);
      }
    }

    $this->mapper->mapObject(json_decode($response->getBody()), $echoResponse);
    $this->crypto->verifySignature($echoResponse, $echoResponse->signature);
    return $echoResponse;
  }

  function applepayInit(ApplepayInitRequest $request): InitResponse
  {
    $this->crypto->createSignature($request);
    $initResponse = new InitResponse();
    try {
      $response = $this->client->connector()->request('POST', $this->client->baseUrl() . "/applepay/init", ['body' => json_encode($request)]);
    }
    catch (\GuzzleHttp\Exception\RequestException $e) {
      if ($e->hasResponse()) {
        $response = $e->getResponse();
      }
      else {
        $this->logger->error($e);
      }
    }
    $this->mapper->mapObject(json_decode($response->getBody()), $initResponse);
    $this->crypto->verifySignature($initResponse, $initResponse->signature);
    return $initResponse;
  }

  function oneclickEcho(OneclickEchoRequest $request): OneclickEchoResponse
  {
    $this->crypto->createSignature($request);
    $response = $this->client->connector()->request('POST', $this->client->baseUrl() . "/oneclick/echo", ['body' => json_encode($request)]);
    $echoResponse = new OneclickEchoresponse();
    $this->mapper->mapObject(json_decode($response->getBody()), $echoResponse);
    $this->crypto->verifySignature($echoResponse, $echoResponse->signature);
    return $echoResponse;
  }

  function oneclickInit(OneclickInitRequest $request): InitResponse
  {
    $this->crypto->createSignature($request);
    $response = $this->client->connector()->request('POST', $this->client->baseUrl() . "/oneclick/init", ['body' => json_encode($request)]);
    $initResponse = new InitResponse();
    $this->mapper->mapObject(json_decode($response->getBody()), $initResponse);
    $this->crypto->verifySignature($initResponse, $initResponse->signature);
    return $initResponse;
  }

  function oneclickProcess(OneclickProcessRequest $request): ProcessResponse
  {
    $this->crypto->createSignature($request);
    $response = $this->client->connector()->request('POST', $this->client->baseUrl() . "/oneclick/process", ['body' => json_encode($request)]);
    $processResponse = new ProcessResponse();
    $this->mapper->mapObject(json_decode($response->getBody()), $processResponse);
    $this->crypto->verifySignature($processResponse, $processResponse->signature);
    return $processResponse;
  }

  function paymentStatus(PaymentStatusRequest $request): PaymentStatusResponse
  {
    $this->crypto->createSignature($request);
    $response = $this->client->connector()->request('GET', $this->client->baseUrl() . "/payment/status/" . $request->merchantId . "/" . $request->payId . "/" . $request->dttm . "/" . urlencode($request->signature));
    $statusResponse = new PaymentStatusResponse();
    $this->mapper->mapObject(json_decode($response->getBody()), $statusResponse);
    $this->crypto->verifySignature($statusResponse, $statusResponse->signature);
    return $statusResponse;
  }

  function paymentInit(PaymentInitRequest $request): PaymentInitResponse
  {
    $this->crypto->createSignature($request);
    $processResponse = new PaymentInitResponse();
    try {
      $response = $this->client->connector()->request('POST', $this->client->baseUrl() . "/payment/init", ['body' => json_encode($request)]);
    }
    catch (\GuzzleHttp\Exception\RequestException $e) {
      if ($e->hasResponse()) {
        $response = $e->getResponse();
      }
      else {
        $this->logger->error($e);
      }
    }

    $this->mapper->mapObject(json_decode($response->getBody()), $processResponse);
    $this->crypto->verifySignature($processResponse, $processResponse->signature);
    return $processResponse;
  }

  function paymentClose(PaymentCloseRequest $request): PaymentResponse
  {
    $this->crypto->createSignature($request);
    $response = $this->client->connector()->request('PUT', $this->client->baseUrl() . "/payment/close", ['body' => json_encode($request)]);
    $closeResponse = new PaymentResponse();
    $this->mapper->mapObject(json_decode($response->getBody()), $closeResponse);
    $this->crypto->verifySignature($closeResponse, $closeResponse->signature);
    return $closeResponse;
  }

  function paymentReverse(PaymentReverseRequest $request): PaymentResponse
  {
    $this->crypto->createSignature($request);
    $response = $this->client->connector()->request('PUT', $this->client->baseUrl() . "/payment/reverse", ['body' => json_encode($request)]);
    $reverseResponse = new PaymentResponse();
    $this->mapper->mapObject(json_decode($response->getBody()), $reverseResponse);
    $this->crypto->verifySignature($reverseResponse, $reverseResponse->signature);
    return $reverseResponse;
  }

  function paymentRefund(PaymentRefundRequest $request): PaymentResponse
  {
    $this->crypto->createSignature($request);
    $response = $this->client->connector()->request('PUT', $this->client->baseUrl() . "/payment/refund", ['body' => json_encode($request)]);
    $refundResponse = new PaymentResponse();
    $this->mapper->mapObject(json_decode($response->getBody()), $refundResponse);
    $this->crypto->verifySignature($refundResponse, $refundResponse->signature);
    return $refundResponse;
  }

  function paymentProcess(PaymentProcessRequest $request): string
  {
    $this->crypto->createSignature($request);
    $response = $this->client->connector()->get($this->client->baseUrl() . "/payment/process/" . $request->merchantId . "/" . $request->payId . "/" . $request->dttm . "/" . urlencode($request->signature), ['allow_redirects' => false, 'track_redirects' => true]);
    return $response->getHeaderLine("Location");
  }
}


abstract class SignBase implements Signable
{
  public ?string $dttm;
  public ?string $signature = null;

  protected function removeLast(string $data2Sign): string
  {
    if (strlen($data2Sign) >= 1 && $data2Sign[strlen($data2Sign) - 1] == '|') {
      $data2Sign = substr($data2Sign, 0, strlen($data2Sign) - 1);
    }
    return $data2Sign;
  }
}

interface Signable
{
  public function toSign(): string;
}
class EchoRequest extends SignBase
{
  public string $merchantId;

  function __construct(string $merchantId)
  {
    $this->merchantId = $merchantId;
  }

  function toSign(): string
  {
    return $this->removeLast("{$this->merchantId}|{$this->dttm}");
  }
}

class ApplepayEchoResponse extends SignBase
{

  public int $resultCode;
  public string $resultMessage;
  /** @var ApplepayInitParams */
  public ApplepayInitParams $initParams;


  function toSign(): string
  {
    $sb = "";
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->resultCode))
      $sb = ApiUtilsAdd($sb, $this->resultCode);
    if (isset($this->resultMessage))
      $sb = ApiUtilsAdd($sb, $this->resultMessage);
    if (isset($this->initParams))
      $sb = ApiUtilsAdd($sb, $this->initParams->toSign());
    return $this->removeLast($sb);
  }
}

class ApplepayInitParams extends SignBase
{
  public string $countryCode;
  /** @var string[] */
  public $supportedNetworks;
  /** @var string[] */
  public $merchantCapabilities;
  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    if (isset($this->countryCode))
      $sb = ApiUtilsAdd($sb, $this->countryCode);
    if (isset($this->supportedNetworks))
      foreach ($this->supportedNetworks as $network) {
        $sb = ApiUtilsAdd($sb, $network);
      }
    if (isset($this->merchantCapabilities))
      foreach ($this->merchantCapabilities as $capability) {
        $sb = ApiUtilsAdd($sb, $capability);
      }
    return $this->removeLast($sb);
  }
}

class Customer extends SignBase
{
  public string $merchantId;
  public string $name;
  public string $email;
  public string $homePhone;
  public string $workPhone;
  public string $mobilePhone;
  public Account $account;
  public Login $login;
  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    if (isset($this->name))
      $sb = ApiUtilsAdd($sb, $this->name);
    if (isset($this->email))
      $sb = ApiUtilsAdd($sb, $this->email);
    if (isset($this->homePhone))
      $sb = ApiUtilsAdd($sb, $this->homePhone);
    if (isset($this->workPhone))
      $sb = ApiUtilsAdd($sb, $this->workPhone);
    if (isset($this->mobilePhone))
      $sb = ApiUtilsAdd($sb, $this->mobilePhone);
    if (isset($this->account))
      $sb = ApiUtilsAdd($sb, $this->account->toSign());
    if (isset($this->login))
      $sb = ApiUtilsAdd($sb, $this->login->toSign());
    return $this->removeLast($sb);
  }
}

class Order extends SignBase
{
  public string $type; //[purchase, balance, prepaid, cash, check]
  public string $availability;
  public string $delivery; //[shipping, shipping_verified, instore, digital, ticket, order]
  public string $deliveryMode; //[0, 1, 2, 3]
  public string $deliveryEmail;
  public bool $nameMatch;
  public bool $addressMatch;
  public Address $billing;
  public Address $shipping;
  public string $shippingAddedAt;
  public bool $reorder;
  public GiftCards $giftcards;

  public function toSign(): string
  {
    $sb = "";
    if (isset($this->type))
      $sb = ApiUtilsAdd($sb, $this->type);
    if (isset($this->availability))
      $sb = ApiUtilsAdd($sb, $this->availability);
    if (isset($this->delivery))
      $sb = ApiUtilsAdd($sb, $this->delivery);
    if (isset($this->deliveryMode))
      $sb = ApiUtilsAdd($sb, $this->deliveryMode);
    if (isset($this->deliveryEmail))
      $sb = ApiUtilsAdd($sb, $this->deliveryEmail);
    if (isset($this->nameMatch))
      $sb = ApiUtilsAdd($sb, $this->nameMatch);
    if (isset($this->addressMatch))
      $sb = ApiUtilsAdd($sb, $this->addressMatch);
    if (isset($this->billing))
      $sb = ApiUtilsAdd($sb, $this->billing->toSign());
    if (isset($this->shipping))
      $sb = ApiUtilsAdd($sb, $this->shipping->toSign());
    if (isset($this->shippingAddedAt))
      $sb = ApiUtilsAdd($sb, $this->shippingAddedAt);
    if (isset($this->reorder))
      $sb = ApiUtilsAdd($sb, $this->reorder);
    if (isset($this->giftcards))
      $sb = ApiUtilsAdd($sb, $this->giftcards->toSign());
    return $this->removeLast($sb);
  }
}

class Account extends SignBase
{
  public string $createdAt;
  public string $changedAt;
  public string $changedPwdAt;
  public int $orderHistory;
  public int $paymentsDay;
  public int $paymentsYear;
  public int $oneclickAdds;
  public bool $suspicious;
  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    if (isset($this->createdAt))
      $sb = ApiUtilsAdd($sb, $this->createdAt);
    if (isset($this->changedAt))
      $sb = ApiUtilsAdd($sb, $this->changedAt);
    if (isset($this->changedPwdAt))
      $sb = ApiUtilsAdd($sb, $this->changedPwdAt);
    if (isset($this->orderHistory))
      $sb = ApiUtilsAdd($sb, $this->orderHistory);
    if (isset($this->paymentsDay))
      $sb = ApiUtilsAdd($sb, $this->paymentsDay);
    if (isset($this->paymentsYear))
      $sb = ApiUtilsAdd($sb, $this->paymentsYear);
    if (isset($this->oneclickAdds))
      $sb = ApiUtilsAdd($sb, $this->oneclickAdds);
    if (isset($this->suspicious))
      $sb = ApiUtilsAdd($sb, $this->suspicious);
    return $this->removeLast($sb);
  }
}

class Login extends SignBase
{
  public string $auth;
  public string $authAt;
  public string $authData;

  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    if (isset($this->auth))
      $sb = ApiUtilsAdd($sb, $this->auth);
    if (isset($this->authAt))
      $sb = ApiUtilsAdd($sb, $this->authAt);
    if (isset($this->authData))
      $sb = ApiUtilsAdd($sb, $this->authData);
    return $this->removeLast($sb);
  }
}

class Address extends SignBase
{
  public string $address1;
  public string $address2;
  public string $address3;
  public string $city;
  public string $zip;
  public string $state;
  public string $country;
  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    if (isset($this->address1))
      $sb = ApiUtilsAdd($sb, $this->address1);
    if (isset($this->address2))
      $sb = ApiUtilsAdd($sb, $this->address2);
    if (isset($this->address3))
      $sb = ApiUtilsAdd($sb, $this->address3);
    if (isset($this->city))
      $sb = ApiUtilsAdd($sb, $this->city);
    if (isset($this->zip))
      $sb = ApiUtilsAdd($sb, $this->zip);
    if (isset($this->state))
      $sb = ApiUtilsAdd($sb, $this->state);
    if (isset($this->country))
      $sb = ApiUtilsAdd($sb, $this->country);
    return $this->removeLast($sb);
  }
}

class OneclickEchoRequest extends SignBase
{

  public string $merchantId;
  public string $origPayId;

  function toSign(): string
  {
    $sb = "";
    if (isset($this->merchantId))
      $sb = ApiUtilsAdd($sb, $this->merchantId);
    if (isset($this->origPayId))
      $sb = ApiUtilsAdd($sb, $this->origPayId);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    return $this->removeLast($sb);
  }
}

class OneclickEchoResponse extends SignBase
{

  public string $origPayId;

  public int $resultCode;

  public string $resultMessage;
  /** @var Extension[] */
  public $extensions;
  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    $sb = ApiUtilsAdd($sb, $this->origPayId);
    $sb = ApiUtilsAdd($sb, $this->dttm);
    $sb = ApiUtilsAdd($sb, $this->resultCode);
    $sb = ApiUtilsAdd($sb, $this->resultMessage);
    return $this->removeLast($sb);
  }
}
class OneclickInitRequest extends SignBase
{
  public string $merchantId;
  public float $totalAmount;
  public string $currency;

  public string $origPayId;
  public string $orderNo;
  public string $payMethod;
  public string $clientIp;
  public bool $closePayment;
  public string $returnUrl;
  public string $returnMethod;
  public Customer $customer;
  public Order $order;
  public bool $clientInitiated;
  public bool $sdkUsed;
  public string $merchantData;
  /** @var Extension[] */
  public $extensions;
  public int ttlSec;

  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    if (isset($this->merchantId))
      $sb = ApiUtilsAdd($sb, $this->merchantId);
    if (isset($this->origPayId))
      $sb = ApiUtilsAdd($sb, $this->origPayId);
    if (isset($this->orderNo))
      $sb = ApiUtilsAdd($sb, $this->orderNo);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->clientIp))
      $sb = ApiUtilsAdd($sb, $this->clientIp);
    if (isset($this->totalAmount))
      $sb = ApiUtilsAdd($sb, $this->totalAmount);
    if (isset($this->currency))
      $sb = ApiUtilsAdd($sb, $this->currency);
    if (isset($this->closePayment))
      $sb = ApiUtilsAdd($sb, $this->closePayment);
    if (isset($this->returnUrl))
      $sb = ApiUtilsAdd($sb, $this->returnUrl);
    if (isset($this->returnMethod))
      $sb = ApiUtilsAdd($sb, $this->returnMethod);
    if (isset($this->customer))
      $sb = ApiUtilsAdd($sb, $this->customer->toSign());
    if (isset($this->order))
      $sb = ApiUtilsAdd($sb, $this->order->toSign());
    if (isset($this->clientInitiated))
      $sb = ApiUtilsAdd($sb, $this->clientInitiated);
    if (isset($this->sdkUsed))
      $sb = ApiUtilsAdd($sb, $this->sdkUsed);
    if (isset($this->merchantData))
      $sb = ApiUtilsAdd($sb, $this->merchantData);
    if (isset($this->ttlSec))
      $sb = ApiUtilsAdd($sb, $this->ttlSec);
    return $this->removeLast($sb);
  }
}

class InitResponse extends SignBase
{
  public string $payId;
  public int $resultCode;
  public string $resultMessage;
  public int $paymentStatus;
  public string $statusDetail;
  /** @var AuthInit */
  public $actions;
  function toSign(): string
  {
    $sb = "";
    if (isset($this->payId))
      $sb = ApiUtilsAdd($sb, $this->payId);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->resultCode))
      $sb = ApiUtilsAdd($sb, $this->resultCode);
    if (isset($this->resultMessage))
      $sb = ApiUtilsAdd($sb, $this->resultMessage);
    if (isset($this->paymentStatus))
      $sb = ApiUtilsAdd($sb, $this->paymentStatus);
    if (isset($this->statusDetail))
      $sb = ApiUtilsAdd($sb, $this->statusDetail);
    if (isset($this->actions))
      $sb = ApiUtilsAdd($sb, $this->actions->toSign());
    return $this->removeLast($sb);
  }
}
class ProcessResponse extends SignBase
{
  public string $payId;
  public int $resultCode;
  public string $resultMessage;
  public int $paymentStatus;
  public string $statusDetail;
  public $actions;

  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    if (isset($this->payId))
      $sb = ApiUtilsAdd($sb, $this->payId);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->resultCode))
      $sb = ApiUtilsAdd($sb, $this->resultCode);
    if (isset($this->resultMessage))
      $sb = ApiUtilsAdd($sb, $this->resultMessage);
    if (isset($this->paymentStatus))
      $sb = ApiUtilsAdd($sb, $this->paymentStatus);
    if (isset($this->statusDetail))
      $sb = ApiUtilsAdd($sb, $this->statusDetail);
    if (isset($this->actions))
      $sb = ApiUtilsAdd($sb, $this->actions->toSign());
    return $this->removeLast($sb);
  }
}

class ApplepayProcessRequest extends SignBase
{
  public string $merchantId;
  public string $payId;

  public AuthData $fingerprint;

  function __construct(string $merchantId, string $payId, AuthData $fingerprint)
  {
    $this->merchantId = $merchantId;
    $this->payId = $payId;
    $this->fingerprint = $fingerprint;
  }

  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    $sb = ApiUtilsAdd($sb, $this->merchantId);
    $sb = ApiUtilsAdd($sb, $this->payId);
    $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->fingerprint))
      $sb = ApiUtilsAdd($sb, $this->fingerprint->toSign());
    return $this->removeLast($sb);
  }
}

class GooglepayProcessRequest extends SignBase
{
  public string $merchantId;
  public string $payId;

  public AuthData $fingerprint;

  function __construct(string $merchantId, string $payId, AuthData $fingerprint)
  {
    $this->merchantId = $merchantId;
    $this->payId = $payId;
    $this->fingerprint = $fingerprint;
  }

  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    $sb = ApiUtilsAdd($sb, $this->merchantId);
    $sb = ApiUtilsAdd($sb, $this->payId);
    $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->fingerprint))
      $sb = ApiUtilsAdd($sb, $this->fingerprint->toSign());
    return $this->removeLast($sb);
  }
}

class OneclickProcessRequest extends SignBase
{
  public string $merchantId;
  public string $payId;

  public AuthData $fingerprint;

  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    $sb = ApiUtilsAdd($sb, $this->merchantId);
    $sb = ApiUtilsAdd($sb, $this->payId);
    $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->fingerprint))
      $sb = ApiUtilsAdd($sb, $this->fingerprint->toSign());
    return $this->removeLast($sb);
  }
}

class AuthData implements Signable
{
  public Auth3dsBrowser $browser;
  public $sdk;

  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    if (isset($this->browser))
      $sb = ApiUtilsAdd($sb, $this->browser->toSign());
    if (isset($this->sdk))
      $sb = ApiUtilsAdd($sb, $this->sdk->toSign());
    return $this->removeLast($sb);
  }
  protected function removeLast(string $data2Sign): string
  {
    if (strlen($data2Sign) >= 1 && $data2Sign[strlen($data2Sign) - 1] == '|') {
      $data2Sign = substr($data2Sign, 0, strlen($data2Sign) - 1);
    }
    return $data2Sign;
  }
}

class Auth3dsBrowser extends SignBase
{
  public string $acceptHeader;
  public bool $javaEnabled;
  public string $language;
  public int $colorDepth;
  public int $screenHeight;
  public int $screenWidth;
  public int $timezone;
  public string $userAgent;
  public string $challengeWindowSize;
  public bool $javascriptEnabled;


  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    if (isset($this->acceptHeader))
      $sb = ApiUtilsAdd($sb, $this->acceptHeader);
    if (isset($this->javaEnabled))
      $sb = ApiUtilsAdd($sb, $this->javaEnabled);
    if (isset($this->language))
      $sb = ApiUtilsAdd($sb, $this->language);
    if (isset($this->colorDepth))
      $sb = ApiUtilsAdd($sb, $this->colorDepth);
    if (isset($this->screenHeight))
      $sb = ApiUtilsAdd($sb, $this->screenHeight);
    if (isset($this->screenWidth))
      $sb = ApiUtilsAdd($sb, $this->screenWidth);
    if (isset($this->timezone))
      $sb = ApiUtilsAdd($sb, $this->timezone);
    if (isset($this->userAgent))
      $sb = ApiUtilsAdd($sb, $this->userAgent);
    if (isset($this->challengeWindowSize))
      $sb = ApiUtilsAdd($sb, $this->challengeWindowSize);
    if (isset($this->javascriptEnabled))
      $sb = ApiUtilsAdd($sb, $this->javascriptEnabled);
    return $this->removeLast($sb);
  }
}

class PaymentStatusRequest extends SignBase
{
  public string $payId;
  public string $merchantId;

  function toSign(): string
  {
    $sb = "";
    if (isset($this->merchantId))
      $sb = ApiUtilsAdd($sb, $this->merchantId);
    if (isset($this->payId))
      $sb = ApiUtilsAdd($sb, $this->payId);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    return $this->removeLast($sb);
  }
}

class PaymentStatusResponse extends SignBase
{
  public string $payId;
  public int $resultCode;
  public string $resultMessage;
  public int $paymentStatus;
  public string $authCode;
  public string $statusDetail;
  public $actions;
  /** @var Extension[] */
  public $extensions;

  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    if (isset($this->payId))
      $sb = ApiUtilsAdd($sb, $this->payId);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->resultCode))
      $sb = ApiUtilsAdd($sb, $this->resultCode);
    if (isset($this->resultMessage))
      $sb = ApiUtilsAdd($sb, $this->resultMessage);
    if (isset($this->authCode))
      $sb = ApiUtilsAdd($sb, $this->authCode);
    if (isset($this->statusDetail))
      $sb = ApiUtilsAdd($sb, $this->statusDetail);
    if (isset($this->actions))
      $sb = ApiUtilsAdd($sb, $this->actions->toSign());
    return $this->removeLast($sb);
  }
}

class PaymentInitRequest extends SignBase
{
  public string $merchantId;
  public float $totalAmount;
  public string $currency;
  public string $orderNo;
  public string $payOperation; //[payment, oneclickPayment]
  public string $payMethod; //[card, cart#LVP]
  public bool $closePayment;

  /** @var CartItem[] */
  public $cart;
  public string $returnUrl;
  public string $returnMethod; //[GET, POST]
  /** @var Customer */
  public ?Cutomer $customer;
  /** @var Order */
  public ?Order $order;
  public string $merchantData;
  public string $language;
  public int $ttlSec;

  function toSign(): string
  {
    $sb = "";
    if (isset($this->merchantId))
      $sb = ApiUtilsAdd($sb, $this->merchantId);
    if (isset($this->orderNo))
      $sb = ApiUtilsAdd($sb, $this->orderNo);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->payOperation))
      $sb = ApiUtilsAdd($sb, $this->payOperation);
    if (isset($this->payMethod))
      $sb = ApiUtilsAdd($sb, $this->payMethod);
    if (isset($this->totalAmount))
      $sb = ApiUtilsAdd($sb, $this->totalAmount);
    if (isset($this->currency))
      $sb = ApiUtilsAdd($sb, $this->currency);
    if (isset($this->closePayment))
      $sb = ApiUtilsAdd($sb, $this->closePayment);

    if (isset($this->returnUrl))
      $sb = ApiUtilsAdd($sb, $this->returnUrl);
    if (isset($this->returnMethod))
      $sb = ApiUtilsAdd($sb, $this->returnMethod);

    foreach ($this->cart as $item) {
      $sb = ApiUtilsAdd($sb, $item->toSign());
    }


    if (isset($this->customer))
      $sb = ApiUtilsAdd($sb, $this->customer->toSign());
    if (isset($this->order))
      $sb = ApiUtilsAdd($sb, $this->order->toSign());
    if (isset($this->merchantData))
      $sb = ApiUtilsAdd($sb, $this->merchantData);
    if (isset($this->language))
      $sb = ApiUtilsAdd($sb, $this->language);
    if (isset($this->ttlSec))
      $sb = ApiUtilsAdd($sb, $this->ttlSec);
    return $this->removeLast($sb);
  }
}

function ApiUtilsAdd(string $s, $field)
{
  if (is_bool($field))
    $s .= var_export($field, true) . "|";
  else
    $s .= $field . "|";
  return $s;
}

class PaymentInitResponse extends SignBase
{
  public string $payId;
  public int $resultCode;
  public string $resultMessage;
  public int $paymentStatus;
  public string $authCode;
  public string $statusDetail;

  function toSign(): string
  {
    $sb = "";
    if (isset($this->payId))
      $sb = ApiUtilsAdd($sb, $this->payId);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->resultCode))
      $sb = ApiUtilsAdd($sb, $this->resultCode);
    if (isset($this->resultMessage))
      $sb = ApiUtilsAdd($sb, $this->resultMessage);
    if (isset($this->paymentStatus))
      $sb = ApiUtilsAdd($sb, $this->paymentStatus);
    if (isset($this->authCode))
      $sb = ApiUtilsAdd($sb, $this->authCode);
    if (isset($this->statusDetail))
      $sb = ApiUtilsAdd($sb, $this->statusDetail);
    return $this->removeLast($sb);
  }

}

class CartItem extends SignBase
{
  public string $name;
  public int $quantity;
  public float $amount;
  public string $description;

  function toSign(): string
  {
    $sb = "";
    if (isset($this->name))
      $sb = ApiUtilsAdd($sb, $this->name);
    if (isset($this->quantity))
      $sb = ApiUtilsAdd($sb, $this->quantity);
    if (isset($this->amount))
      $sb = ApiUtilsAdd($sb, $this->amount);
    if (isset($this->description))
      $sb = ApiUtilsAdd($sb, $this->description);
    return $this->removeLast($sb);
  }
}

class PaymentCloseRequest extends SignBase
{
  public string $merchantId;
  public string $payId;
  public float $totalAmount;
  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    if (isset($this->merchantId))
      $sb = ApiUtilsAdd($sb, $this->merchantId);
    if (isset($this->payId))
      $sb = ApiUtilsAdd($sb, $this->payId);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->totalAmount))
      $sb = ApiUtilsAdd($sb, $this->totalAmount);
    return $this->removeLast($sb);
  }
}

class PaymentResponse extends SignBase
{
  public string $payId;
  public int $resultCode;
  public string $resultMessage;
  public int $paymentStatus;
  public string $authCode;
  public string $statusDetail;
  public Actions $actions;
  /**
   *
   * @return string
   */
  function toSign(): string
  {
    $sb = "";
    if (isset($this->payId))
      $sb = ApiUtilsAdd($sb, $this->payId);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->resultCode))
      $sb = ApiUtilsAdd($sb, $this->resultCode);
    if (isset($this->resultMessage))
      $sb = ApiUtilsAdd($sb, $this->resultMessage);
    if (isset($this->paymentStatus))
      $sb = ApiUtilsAdd($sb, $this->paymentStatus);
    if (isset($this->authCode))
      $sb = ApiUtilsAdd($sb, $this->authCode);
    if (isset($this->statusDetail))
      $sb = ApiUtilsAdd($sb, $this->statusDetail);
    if (isset($this->actions))
      $sb = ApiUtilsAdd($sb, $this->$this->actions->toSign());
    return $this->removeLast($sb);
  }
}

class PaymentReverseRequest extends SignBase
{
  public string $merchantId;
  public string $payId;

  function toSign(): string
  {
    $sb = "";
    if (isset($this->merchantId))
      $sb = ApiUtilsAdd($sb, $this->merchantId);
    if (isset($this->payId))
      $sb = ApiUtilsAdd($sb, $this->payId);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    return $this->removeLast($sb);
  }
}

class PaymentRefundRequest extends SignBase
{
  public string $merchantId;
  public string $payId;
  public float $amount;

  function toSign(): string
  {
    $sb = "";
    if (isset($this->merchantId))
      $sb = ApiUtilsAdd($sb, $this->merchantId);
    if (isset($this->payId))
      $sb = ApiUtilsAdd($sb, $this->payId);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->amount))
      $sb = ApiUtilsAdd($sb, $this->amount);
    return $this->removeLast($sb);
  }
}

class PaymentProcessRequest extends SignBase
{
  public string $merchantId;
  public string $payId;
  function toSign(): string
  {
    $sb = "";
    if (isset($this->merchantId))
      $sb = ApiUtilsAdd($sb, $this->merchantId);
    if (isset($this->payId))
      $sb = ApiUtilsAdd($sb, $this->payId);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    return $this->removeLast($sb);
  }
}
class ApplepayInitRequest extends SignBase
{
  public string $merchantId;
  public string $currency;
  public float $totalAmount;

  public string $orderNo;
  public string $payMethod;
  public string $clientIp;
  public bool $closePayment;
  public string $payload;
  public string $returnUrl;
  public string $returnMethod; //[GET, POST]
  public Customer $customer;
  public Order $order;
  public bool $sdkUsed;
  public string $merchantData;
  public int $ttlSec;
  /** @var Extension[] */
  public $extensions;
  function toSign(): string
  {
    $sb = "";
    if (isset($this->merchantId))
      $sb = ApiUtilsAdd($sb, $this->merchantId);
    if (isset($this->orderNo))
      $sb = ApiUtilsAdd($sb, $this->orderNo);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->clientIp))
      $sb = ApiUtilsAdd($sb, $this->clientIp);
    if (isset($this->totalAmount))
      $sb = ApiUtilsAdd($sb, $this->totalAmount);
    if (isset($this->currency))
      $sb = ApiUtilsAdd($sb, $this->currency);
    if (isset($this->closePayment))
      $sb = ApiUtilsAdd($sb, $this->closePayment);
    if (isset($this->payload))
      $sb = ApiUtilsAdd($sb, $this->payload);
    if (isset($this->returnUrl))
      $sb = ApiUtilsAdd($sb, $this->returnUrl);
    if (isset($this->returnMethod))
      $sb = ApiUtilsAdd($sb, $this->returnMethod);
    if (isset($this->customer))
      $sb = ApiUtilsAdd($sb, $this->customer->toSign());
    if (isset($this->order))
      $sb = ApiUtilsAdd($sb, $this->order->toSign());
    if (isset($this->sdkUsed))
      $sb = ApiUtilsAdd($sb, $this->sdkUsed);
    if (isset($this->merchantData))
      $sb = ApiUtilsAdd($sb, $this->merchantData);
    if (isset($this->ttlSec))
      $sb = ApiUtilsAdd($sb, $this->ttlSec);
    return $this->removeLast($sb);
  }
}

abstract class Actions extends SignBase
{
}

class Extension extends SignBase
{
  public string $extension;
  function toSign(): string
  {
    return $this->removeLast("");
  }
}

class MaskedClnRPExtension extends Extension
{

  public string $extension = "maskClnRP";
  public string $maskedCln;
  public string $longMaskedCln;
  public string $expiration;
  function toSign(): string
  {
    $sb = "";
    if (isset($this->extension))
      $sb = ApiUtilsAdd($sb, $this->extension);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->maskedCln))
      $sb = ApiUtilsAdd($sb, $this->maskedCln);
    if (isset($this->expiration))
      $sb = ApiUtilsAdd($sb, $this->expiration);
    if (isset($this->longMaskedCln))
      $sb = ApiUtilsAdd($sb, $this->longMaskedCln);
    return $this->removeLast($sb);
  }
}

class GooglepayEchoResponse extends SignBase
{
  public int $resultCode;
  public string $resultMessage;
  public GooglepayInitParams $initParams;

  function toSign(): string
  {
    $sb = "";
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->resultCode))
      $sb = ApiUtilsAdd($sb, $this->resultCode);
    if (isset($this->resultMessage))
      $sb = ApiUtilsAdd($sb, $this->resultMessage);
    if (isset($this->initParams)) {
      $sb = ApiUtilsAdd($sb, $this->initParams->toSign());
    }
    return $this->removeLast($sb);
  }
}

class GooglepayInitParams extends SignBase
{
  public int $apiVersion = 2;
  public int $apiVersionMinor = 0;
  public string $paymentMethodType;
  /** @var string[] */
  public $allowedCardNetworks;
  /** @var string[] */
  public $allowedCardAuthMethods;
  public bool $assuranceDetailsRequired;
  public bool $billingAddressRequired;
  public string $billingAddressParametersFormat;
  public string $tokenizationSpecificationType;
  public string $gateway;
  public string $gatewayMerchantId;
  public string $googlepayMerchantId;
  public string $merchantName;
  public string $environment;
  public string $totalPriceStatus;
  public string $countryCode;
  function toSign(): string
  {
    $sb = "";
    if (isset($this->apiVersion))
      $sb = ApiUtilsAdd($sb, $this->apiVersion);
    if (isset($this->apiVersionMinor))
      $sb = ApiUtilsAdd($sb, $this->apiVersionMinor);
    foreach ($this->allowedCardNetworks as $value) {
      $sb = ApiUtilsAdd($sb, $value);
    }

    foreach ($this->allowedCardAuthMethods as $value) {
      $sb = ApiUtilsAdd($sb, $value);
    }

    if (isset($this->googlepayMerchantId))
      $sb = ApiUtilsAdd($sb, $this->googlepayMerchantId);
    if (isset($this->merchantName))
      $sb = ApiUtilsAdd($sb, $this->merchantName);
    if (isset($this->totalPriceStatus))
      $sb = ApiUtilsAdd($sb, $this->totalPriceStatus);
    return $this->removeLast($sb);
  }
}

class GooglepayInitRequest extends SignBase
{

  public string $merchantId;
  public float $totalAmount;
  public string $currency;

  public string $orderNo;
  public string $payMethod;
  public string $clientIp;
  public bool $closePayment;
  public string $payload;
  public string $returnUrl;
  public string $returnMethod; //[GET, POST]
  public Customer $customer;
  public Order $order;
  public bool $sdkUsed;
  public string $merchantData;
  public int $ttlSec;
  /** @var Extension[] */
  public $extensions;
  function toSign(): string
  {
    $sb = "";
    if (isset($this->merchantId))
      $sb = ApiUtilsAdd($sb, $this->merchantId);
    if (isset($this->orderNo))
      $sb = ApiUtilsAdd($sb, $this->orderNo);
    if (isset($this->dttm))
      $sb = ApiUtilsAdd($sb, $this->dttm);
    if (isset($this->clientIp))
      $sb = ApiUtilsAdd($sb, $this->clientIp);
    if (isset($this->totalAmount))
      $sb = ApiUtilsAdd($sb, $this->totalAmount);
    if (isset($this->currency))
      $sb = ApiUtilsAdd($sb, $this->currency);
    if (isset($this->closePayment))
      $sb = ApiUtilsAdd($sb, $this->closePayment);
    if (isset($this->merchantData))
      $sb = ApiUtilsAdd($sb, $this->merchantData);
    if (isset($this->payload))
      $sb = ApiUtilsAdd($sb, $this->payload);
    if (isset($this->returnUrl))
      $sb = ApiUtilsAdd($sb, $this->returnUrl);
    if (isset($this->returnMethod))
      $sb = ApiUtilsAdd($sb, $this->returnMethod);
    if (isset($this->customer))
      $sb = ApiUtilsAdd($sb, $this->customer->toSign());
    if (isset($this->order))
      $sb = ApiUtilsAdd($sb, $this->order->toSign());
    if (isset($this->ttlSec))
      $sb = ApiUtilsAdd($sb, $this->ttlSec);
    return $this->removeLast($sb);
  }
}

class Endpoint extends Signbase
{
  public string $url;
  public string $method;
  /** @var string[] */
  public $params;
  function toSign(): string
  {
    $sb = "";
    if (isset($this->url))
      $sb = ApiUtilsAdd($sb, $this->url);
    if (isset($this->method))
      $sb = ApiUtilsAdd($sb, $this->method);
    return $this->removeLast($sb);
  }
}

class AuthInit extends Actions
{
  public ?Endpoint $browserInit;
  public ?SdkInit $sdkInit;

  function toSign(): string
  {
    $sb = "";
    if (isset($this->browserInit))
      $sb = ApiUtilsAdd($sb, $this->browserInit->toSign());
    if (isset($this->sdkInit))
      $sb = ApiUtilsAdd($sb, $this->sdkInit->toSign());

    return $this->removeLast($sb);
  }



}

class EchoResponse extends SignBase
{
  public int $resultCode;
  public string $resultMessage;
  function toSign(): string
  {
    $sb = "";
    $sb = ApiUtilsAdd($sb, $this->dttm);
    $sb = ApiUtilsAdd($sb, $this->resultCode);
    $sb = ApiUtilsAdd($sb, $this->resultMessage);
    return $this->removeLast($sb);
  }

}

?>