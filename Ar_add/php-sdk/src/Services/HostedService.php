<?php

namespace GlobalPayments\Api\Services;

use GlobalPayments\Api\Builders\AuthorizationBuilder;
use GlobalPayments\Api\Builders\ManagementBuilder;
use GlobalPayments\Api\Entities\Enums\PaymentMethodType;
use GlobalPayments\Api\Entities\Enums\ShaHashType;
use GlobalPayments\Api\Entities\Enums\TransactionType;
use GlobalPayments\Api\PaymentMethods\TransactionReference;
use GlobalPayments\Api\ServicesContainer;
use GlobalPayments\Api\Utils\GenerationUtils;
use GlobalPayments\Api\Entities\Exceptions\ApiException;
use GlobalPayments\Api\Entities\Transaction;
use GlobalPayments\Api\ServiceConfigs\ServicesConfig;

class HostedService
{

    /**
     * Shared secret to authenticate with the gateway
     *
     * @var string
     */
    public $sharedSecret;

    public $shaHashType = ShaHashType::SHA1;

    private static $supportedShaType = [
        ShaHashType::SHA1,
        ShaHashType::SHA256
    ];

    /**
     * Instatiates a new object
     *
     * @param ServicesConfig $config Service config
     *
     * @return void
     */
    public function __construct($config)
    {
        if (!in_array($config->shaHashType, self::$supportedShaType)) {
            throw new ApiException(sprintf("%s not supported. Please check your code and the Developers Documentation.", $config->shaHashType));
        }
        ServicesContainer::configureService($config);
        $this->sharedSecret = $config->sharedSecret;
        $this->shaHashType = $config->shaHashType;
    }

    /**
     * Creates an authorization builder with type
     * `TransactionType::CREDIT_AUTH`
     *
     * @param string|float $amount Amount to authorize
     *
     * @return AuthorizationBuilder
     */
    public function authorize($amount = null)
    {
        return (new AuthorizationBuilder(TransactionType::AUTH))
            ->withAmount($amount);
    }

    /**
     * Authorizes the payment method and captures the entire authorized amount
     *
     * @param string|float $amount Amount to authorize
     *
     * @return AuthorizationBuilder
     */
    public function charge($amount = null)
    {
        return (new AuthorizationBuilder(TransactionType::SALE))
            ->withAmount($amount);
    }

    /**
     * Verifies the payment method
     *
     * @return AuthorizationBuilder
     */
    public function verify($amount = null)
    {
        return (new AuthorizationBuilder(TransactionType::VERIFY))
            ->withAmount($amount);
    }

    public function void($transaction = null)
    {
        if (!($transaction instanceof TransactionReference)) {
            $transactionReference = new TransactionReference();
            $transactionReference->transactionId = $transaction;
            $transactionReference->paymentMethodType = PaymentMethodType::CREDIT;
            $transaction = $transactionReference;
        }

        return (new ManagementBuilder(TransactionType::VOID))
            ->withPaymentMethod($transaction);
    }

    public function parseResponse($response, $encoded = false)
    {
        if (empty($response)) {
            throw new ApiException("Enable to parse : empty response");
        }

        $response = json_decode($response, true);

        if ($encoded) {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($response));
            foreach ($iterator as $key => $value) {
                if (!empty($value)) {
                    $iterator->getInnerIterator()->offsetSet($key, base64_decode($value));
                }
            }

            $response = $iterator->getArrayCopy();
        }

        $timestamp = $response["TIMESTAMP"];
        $merchantId = $response["MERCHANT_ID"];
        $orderId = $response["ORDER_ID"];
        $result = $response["RESULT"];
        $message = $response["MESSAGE"];
        $transactionId = $response["PASREF"];
        $authCode = $response["AUTHCODE"];
        if (empty($response[$this->shaHashType . "HASH"])) {
            throw new ApiException("SHA hash is missing. Please check your code and the Developers Documentation.");
        }
        $shaHash = $response[$this->shaHashType . "HASH"];
        $hash = GenerationUtils::generateNewHash(
            $this->sharedSecret,
            implode('.', [
                $timestamp,
                $merchantId,
                $orderId,
                $result,
                $message,
                $transactionId,
                $authCode
            ]),
            $this->shaHashType
        );

        if ($hash != $shaHash) {
            throw new ApiException("Incorrect hash. Please check your code and the Developers Documentation.");
        }

        $ref = new TransactionReference();
        $ref->authCode = $authCode;
        $ref->orderId = $orderId;
        $ref->paymentMethodType = PaymentMethodType::CREDIT;
        $ref->transactionId = $transactionId;

        $trans = new Transaction();

        if (isset($response["AMOUNT"])) {
            $trans->authorizedAmount = $response["AMOUNT"];
        }

        $trans->cvnResponseCode = $response["CVNRESULT"];
        $trans->responseCode = $result;
        $trans->responseMessage = $message;
        $trans->avsResponseCode = $response["AVSPOSTCODERESULT"];
        $trans->transactionReference = $ref;

        $trans->responseValues = $response;

        return $trans;
    }
}
