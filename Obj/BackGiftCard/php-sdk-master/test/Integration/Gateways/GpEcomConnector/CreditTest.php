<?php

namespace GlobalPayments\Api\Tests\Integration\Gateways\GpEcomConnector;

use GlobalPayments\Api\Entities\Exceptions\GatewayException;
use GlobalPayments\Api\PaymentMethods\CreditCardData;
use GlobalPayments\Api\Services\CreditService;
use GlobalPayments\Api\ServicesContainer;
use GlobalPayments\Api\Tests\Data\TestCards;
use GlobalPayments\Api\Utils\Logging\Logger;
use GlobalPayments\Api\Utils\Logging\SampleRequestLogger;
use PHPUnit\Framework\TestCase;
use GlobalPayments\Api\Entities\Enums\DccProcessor;
use GlobalPayments\Api\Entities\Enums\DccRateType;
use GlobalPayments\Api\ServiceConfigs\Gateways\GpEcomConfig;
use GlobalPayments\Api\Utils\GenerationUtils;

class CreditTest extends TestCase
{
    protected $card;

    public function setup() : void
    {
        $card = new CreditCardData();
        $card->number = '4111111111111111';
        $card->expMonth = 12;
        $card->expYear = TestCards::validCardExpYear();
        $card->cvn = '123';
        $card->cardHolderName = 'Joe Smith';
        $this->card = $card;

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

        $capture = $service->capture($authorization->transactionReference)
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

    public function testCreditRefund()
    {
        $response = $this->card->refund(16)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->execute();

        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    public function testCreditRebate()
    {
        $response = $this->card->charge(17)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->execute();
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode, $response->responseMessage);

        $rebate = $response->refund(17)
            ->withCurrency('USD')
            ->execute();
        $this->assertNotNull($rebate);
        $this->assertEquals('00', $rebate->responseCode, $rebate->responseMessage);
    }

    public function testCreditVoid()
    {
        $response = $this->card->charge(15)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->execute();
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode, $response->responseMessage);

        $voidResponse = $response->void()->execute();
        $this->assertNotNull($voidResponse);
        $this->assertEquals('00', $voidResponse->responseCode, $voidResponse->responseMessage);
    }

    public function testCreditVerify()
    {
        $response = $this->card->verify()
            ->withAllowDuplicates(true)
            ->execute();

        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode);
    }

    protected function getConfig()
    {
        $config = new GpEcomConfig();
        $config->merchantId = 'heartlandgpsandbox';
        $config->accountId = 'api';
        $config->sharedSecret = 'secret';
        $config->rebatePassword = 'rebate';
        $config->refundPassword = 'refund';
        $config->serviceUrl = 'https://api.sandbox.realexpayments.com/epage-remote.cgi';
        $config->requestLogger = new SampleRequestLogger(new Logger("logs"));
        return $config;
    }
    
    protected function dccSetup()
    {
        $config = new GpEcomConfig();
        $config->merchantId = "heartlandgpsandbox";
        $config->accountId = "apidcc";
        $config->refundPassword = "refund";
        $config->sharedSecret = "secret";
        $config->serviceUrl = "https://api.sandbox.realexpayments.com/epage-remote.cgi";
        
        ServicesContainer::configureService($config);
    }
    
    public function testCreditGetDccInfo()
    {
        $this->dccSetup();
        
        $this->card->number = '4002933640008365';
        $orderId = GenerationUtils::generateOrderId();
        
        $dccDetails = $this->card->getDccRate(DccRateType::SALE, DccProcessor::FEXCO)
                    ->withAmount(10)
                    ->withCurrency('USD')
                    ->withOrderId($orderId)
                    ->execute();
       
        $this->assertNotNull($dccDetails);
        $this->assertEquals('00', $dccDetails->responseCode, $dccDetails->responseMessage);
        $this->assertNotNull($dccDetails->dccRateData);
    }
    
    public function testCreditDccRateAuthorize()
    {
        $this->dccSetup();
        
        $this->card->number = '4006097467207025';
        $orderId = GenerationUtils::generateOrderId();
        
        $dccDetails = $this->card->getDccRate(DccRateType::SALE,DccProcessor::FEXCO)
            ->withAmount(1001)
            ->withCurrency('EUR')
            ->withOrderId($orderId)
            ->execute();

        $this->assertNotNull($dccDetails);
        $this->assertEquals('00', $dccDetails->responseCode, $dccDetails->responseMessage);
        $this->assertNotNull($dccDetails->dccRateData);
      
        $response = $this->card->authorize(1001)
            ->withCurrency('EUR')
            ->withAllowDuplicates(true)
            ->withDccRateData($dccDetails->dccRateData)
            ->withOrderId($orderId)
            ->execute();
        
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode, $response->responseMessage);
    }
    
    public function testCreditDccRateCharge()
    {
        $this->dccSetup();
        
        $this->card->number = '4006097467207025';
        $orderId = GenerationUtils::generateOrderId();
        
        $dccDetails = $this->card->getDccRate(DccRateType::SALE, DccProcessor::FEXCO)
            ->withAmount(1001)
            ->withCurrency('EUR')
            ->withOrderId($orderId)
            ->execute();
        $this->assertNotNull($dccDetails);
        $this->assertEquals('00', $dccDetails->responseCode, $dccDetails->responseMessage);
        $this->assertNotNull($dccDetails->dccRateData);
        
        $response = $this->card->charge(1001)
            ->withCurrency('EUR')
            ->withAllowDuplicates(true)
            ->withDccRateData($dccDetails->dccRateData)
            ->withOrderId($orderId)
            ->execute();
        
        $this->assertNotNull($response);
        $this->assertEquals('00', $response->responseCode, $response->responseMessage);
    }

    public function testCreditDccInfoNotFound()
    {
        $this->expectException(GatewayException::class);
        $this->expectExceptionMessage("Unexpected Gateway Response: 105 - Cannot find DCC information for that card");
        $this->dccSetup();
        
        $this->card->number = '4002933640008365';
        $orderId = GenerationUtils::generateOrderId();
        
        $dccDetails = $this->card->getDccRate(DccRateType::SALE, DccProcessor::FEXCO)
            ->withAmount(10)
            ->withCurrency('EUR')
            ->withOrderId($orderId)
            ->execute();
    }

    public function testCreditDccInfoMismatch()
    {
        $this->expectException(GatewayException::class);
        $this->expectExceptionMessage("Unexpected Gateway Response: 508 - Incorrect DCC information - doesn't correspond to dccrate request");
        $this->dccSetup();
        
        $this->card->number = '4006097467207025';
        $orderId = GenerationUtils::generateOrderId();
        
        $dccDetails = $this->card->getDccRate(DccRateType::SALE,DccProcessor::FEXCO)
            ->withAmount(10)
            ->withCurrency('EUR')
            ->withOrderId($orderId)
            ->execute();
        
        $this->assertNotNull($dccDetails);
        $this->assertEquals('00', $dccDetails->responseCode, $dccDetails->responseMessage);
        $this->assertNotNull($dccDetails->dccRateData);
        
        $response = $this->card->authorize(100)
            ->withCurrency('EUR')
            ->withAllowDuplicates(true)
            ->withDccRateData($dccDetails->dccRateData)
            ->withOrderId($orderId)
            ->execute();
    }

    public function testCreditAuthorizationWithDynamicDescriptor()
    {
        $dynamicDescriptor = 'My company';
        $authorize = $this->card->authorize(10)
            ->withCurrency('USD')
            ->withAllowDuplicates(true)
            ->withDynamicDescriptor($dynamicDescriptor)
            ->execute();

        $this->assertNotNull($authorize);
        $this->assertEquals('00', $authorize->responseCode, $authorize->responseMessage);

        $capture = $authorize->capture(5)
            ->withDynamicDescriptor($dynamicDescriptor)
            ->execute();

        $this->assertNotNull($capture);
        $this->assertEquals('00', $capture->responseCode, $capture->responseMessage);
    }

    public function testCreditAuthorizationSupplementaryData()
    {
        $authorize = $this->card->authorize(10)
            ->withCurrency('EUR')
            ->withSupplementaryData(["taxInfo" => ["VATREF", "763637283332"]])
            ->withSupplementaryData(["indentityInfo"=> ["Passport", "PPS736353"]])
            ->withSupplementaryData(["RANDOM_KEY1" => "VALUE_1", "RANDOM_KEY2" => "VALUE_2"])
            ->withSupplementaryData('RANDOM_KEY3', 'ACTIVE')
            ->execute();

        $this->assertNotNull($authorize);
        $this->assertEquals('00', $authorize->responseCode, $authorize->responseMessage);

        $capture = $authorize->capture(5)
            ->withSupplementaryData(["taxInfo" => ["VATREF1", "7636372833321"]])
            ->execute();

        $this->assertNotNull($capture);
        $this->assertEquals('00', $capture->responseCode, $capture->responseMessage);
    }
}
