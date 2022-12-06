<?php

namespace GlobalPayments\Api\Tests\Integration\Gateways\PorticoConnector;

use GlobalPayments\Api\Entities\EncryptionData;
use GlobalPayments\Api\PaymentMethods\CreditCardData;
use GlobalPayments\Api\PaymentMethods\CreditTrackData;
use GlobalPayments\Api\Services\CreditService;
use GlobalPayments\Api\ServicesContainer;
use PHPUnit\Framework\TestCase;
use GlobalPayments\Api\Entities\Enums\StoredCredentialInitiator;
use GlobalPayments\Api\Entities\Transaction;
use GlobalPayments\Api\ServiceConfigs\Gateways\PorticoConfig;
use GlobalPayments\Api\Services\ReportingService;
use GlobalPayments\Api\Tests\Data\TestCards;

class CreditTest extends TestCase
{
    protected $card;
    protected $track;
    private $enableCryptoUrl = true;

    public function setup() : void
    {
        $this->card = new CreditCardData();
        $this->card->number = '4111111111111111';
        $this->card->expMonth = 12;
        $this->card->expYear = TestCards::validCardExpYear();
        $this->card->cvn = '123';
        $this->card->cardHolderName = 'Joe Smith';


        $this->track = new CreditTrackData();
        $this->track->value = '<E1050711%B4012001000000016^VI TEST CREDIT^251200000000000000000000?|LO04K0WFOmdkDz0um+GwUkILL8ZZOP6Zc4rCpZ9+kg2T3JBT4AEOilWTI|+++++++Dbbn04ekG|11;4012001000000016=25120000000000000000?|1u2F/aEhbdoPixyAPGyIDv3gBfF|+++++++Dbbn04ekG|00|||/wECAQECAoFGAgEH2wYcShV78RZwb3NAc2VjdXJlZXhjaGFuZ2UubmV0PX50qfj4dt0lu9oFBESQQNkpoxEVpCW3ZKmoIV3T93zphPS3XKP4+DiVlM8VIOOmAuRrpzxNi0TN/DWXWSjUC8m/PI2dACGdl/hVJ/imfqIs68wYDnp8j0ZfgvM26MlnDbTVRrSx68Nzj2QAgpBCHcaBb/FZm9T7pfMr2Mlh2YcAt6gGG1i2bJgiEJn8IiSDX5M2ybzqRT86PCbKle/XCTwFFe1X|>;';
        $this->track->encryptionData = new EncryptionData();
        $this->track->encryptionData->version = '01';

        ServicesContainer::configureService($this->getConfig());
    }

    public function testCreditAuthorization()
    {
        $authorization = $this->card->authorize(14)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->execute();
        $this->assertNotNull($authorization);
        $this->assertEquals('00', $authorization->responseCode);

        $capture = $authorization->capture(16)
            ->withGratuity(2)
            ->execute();
        $this->assertNotNull($capture);
        $this->assertEquals('00', $capture->responseCode);
    }

    public function testCreditServiceAuth()
    {
        $service = new CreditService(
            $this->getConfig()
        );

        $authorization = $service->authorize(15)
            ->withCurrency('USD')
            ->withPaymentMethod($this->card)
            ->withAllowDuplicates(true)
            ->execute();
        $this->assertNotNull($authorization);
        $this->assertEquals('00', $authorization->responseCode);

        $capture = $service->capture($authorization->transactionReference->transactionId)
            ->withAmount(17)
            ->withGratuity(2)
            ->execute();
        $this->assertNotNull($capture);
        $this->assertEquals('00', $capture->responseCode);
    }

    public function testCreditSale()
    {
        $response = $this->card->charge(15)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->execute();

        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testCreditOfflineAuth()
    {
        $response = $this->card->authorize(16)
            ->withCurrency('USD')
            ->withOfflineAuthCode('12345')
            ->withAllowDuplicates(true)
            ->execute();
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testCreditOfflineSale()
    {
        $response = $this->card->charge(16)
            ->withCurrency('USD')
            ->withOfflineAuthCode('12345')
            ->withAllowDuplicates(true)
            ->execute();
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testCreditRefund()
    {
        $response = $this->card->refund(16)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->execute();

        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testCreditReverse()
    {
        $response = $this->card->reverse(15)
            ->withAllowDuplicates(true)
            ->execute();

        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testCreditVerify()
    {
        $response = $this->card->verify()
            ->withAllowDuplicates(true)
            ->execute();

        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testCreditSaleWithSurchargeAmount()
    {
        $amount = 10;
        $surcharge = $amount * .35;
        $response = $this->card->charge($amount + $surcharge)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->withSurchargeAmount($surcharge)
            ->execute();

        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);

        $report = ReportingService::transactionDetail($response->transactionId)->execute();

        $this->assertNotNull($report);
        $this->assertEquals($surcharge, $report->surchargeAmount);
    }

    public function testCreditSwipeAuthorization()
    {
        $authorization = $this->track->authorize(14)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->execute();
        $this->assertNotNull($authorization);
        $this->assertEquals('00', $authorization->responseCode);

        $capture = $authorization->capture(16)
            ->withGratuity(2)
            ->execute();
        $this->assertNotNull($capture);
        $this->assertEquals('00', $capture->responseCode);
    }

    public function testCreditServiceSwipeAuth()
    {
        $service = new CreditService(
            $this->getConfig()
        );

        $authorization = $service->authorize(15)
            ->withCurrency('USD')
            ->withPaymentMethod($this->track)
            ->withAllowDuplicates(true)
            ->execute();
        $this->assertNotNull($authorization);
        $this->assertEquals('00', $authorization->responseCode);

        $capture = $service->capture($authorization->transactionReference->transactionId)
            ->withAmount(17)
            ->withGratuity(2)
            ->execute();
        $this->assertNotNull($capture);
        $this->assertEquals('00', $capture->responseCode);
    }

    public function testCreditSwipeSale()
    {
        $response = $this->track->charge(15)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->execute();

        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testCreditSwipeOfflineAuth()
    {
        $response = $this->track->authorize(16)
            ->withCurrency('USD')
            ->withOfflineAuthCode('12345')
            ->withAllowDuplicates(true)
            ->execute();
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testCreditSwipeOfflineSale()
    {
        $response = $this->track->charge(16)
            ->withCurrency('USD')
            ->withOfflineAuthCode('12345')
            ->withAllowDuplicates(true)
            ->execute();
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testCreditSwipeAddValue()
    {
        $this->markTestSkipped('GSB not configured');

        $response = $this->track->addValue(16)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->execute();
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testCreditSwipeBalanceInquiry()
    {
        $response = $this->track->balanceInquiry()
            ->execute();
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testCreditSwipeRefund()
    {
        $response = $this->track->refund(16)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->execute();

        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testCreditSwipeReverse()
    {
        $response = $this->track->reverse(15)
            ->withAllowDuplicates(true)
            ->execute();

        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testCreditSwipeVerify()
    {
        $response = $this->track->verify()
            ->withAllowDuplicates(true)
            ->execute();

        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    protected function getConfig()
    {
        $config = new PorticoConfig();
        $config->secretApiKey = 'skapi_cert_MTeSAQAfG1UA9qQDrzl-kz4toXvARyieptFwSKP24w';
        $config->serviceUrl = ($this->enableCryptoUrl) ?
                              'https://cert.api2-c.heartlandportico.com/':
                              'https://cert.api2.heartlandportico.com';
        return $config;
    }

    public function testCreditSaleWithCOF()
    {
        $response = $this->card->charge(15)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->withCardBrandStorage(StoredCredentialInitiator::CARDHOLDER)
            ->execute();

        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
        $this->assertNotNull($response->cardBrandTransactionId);

        $nextResponse = $this->card->charge(15)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->withCardBrandStorage(StoredCredentialInitiator::MERCHANT, $response->cardBrandTransactionId)
            ->execute();

        $this->assertNotNull($nextResponse);
        $this->assertEquals('00', $nextResponse->responseCode);
    }

    public function testCreditVerifyWithCOF()
    {
        $response = $this->card->verify()
            ->withAllowDuplicates(true)
            ->withCardBrandStorage(StoredCredentialInitiator::CARDHOLDER)
            ->execute();

        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
        $this->assertNotNull($response->cardBrandTransactionId);

        $nextResponse = $this->card->verify()
            ->withAllowDuplicates(true)
            ->withCardBrandStorage(StoredCredentialInitiator::MERCHANT, $response->cardBrandTransactionId)
            ->execute();

        $this->assertNotNull($nextResponse);
        $this->assertEquals('00', $nextResponse->responseCode);
    }

    public function testCreditAuthorizationWithCOF()
    {
        $response = $this->card->authorize(14)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->withCardBrandStorage(StoredCredentialInitiator::CARDHOLDER)
            ->execute();

        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
        $this->assertNotNull($response->cardBrandTransactionId);

        $nextResponse = $this->card->authorize(14)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->withCardBrandStorage(StoredCredentialInitiator::MERCHANT, $response->cardBrandTransactionId)
            ->execute();

        $this->assertNotNull($nextResponse);
        $this->assertEquals('00', $nextResponse->responseCode);

        $captureResponse = $nextResponse->capture(16)
        ->withGratuity(2)
        ->execute();

        $this->assertNotNull($captureResponse);
        $this->assertEquals('00', $captureResponse->responseCode);
    }

    public function testCreditReverseViaClientTxnId()
    {
        $clientTxnId = time();

        $authorization = $this->card->charge(420.69)
            ->withClientTransactionId($clientTxnId)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->execute();

        $this->assertNotNull($authorization);
        $this->assertEquals('00', $authorization->responseCode);

        $reverse = Transaction::fromClientTransactionId($clientTxnId)
            ->reverse(420.69)
            ->execute();

        $this->assertNotNull($reverse);
        $this->assertEquals('00', $reverse->responseCode);
    }
}
