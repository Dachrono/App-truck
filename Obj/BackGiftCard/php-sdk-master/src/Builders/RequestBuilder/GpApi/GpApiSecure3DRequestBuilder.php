<?php

namespace GlobalPayments\Api\Builders\RequestBuilder\GpApi;

use GlobalPayments\Api\Builders\BaseBuilder;
use GlobalPayments\Api\Builders\Secure3dBuilder;
use GlobalPayments\Api\Entities\Enums\AuthenticationSource;
use GlobalPayments\Api\Entities\Enums\DecoupledFlowRequest;
use GlobalPayments\Api\Entities\Enums\GatewayProvider;
use GlobalPayments\Api\Entities\Enums\TransactionType;
use GlobalPayments\Api\Entities\GpApi\DTO\PaymentMethod;
use GlobalPayments\Api\Entities\GpApi\GpApiRequest;
use GlobalPayments\Api\Entities\IRequestBuilder;
use GlobalPayments\Api\Entities\StoredCredential;
use GlobalPayments\Api\Mapping\EnumMapping;
use GlobalPayments\Api\PaymentMethods\Interfaces\ICardData;
use GlobalPayments\Api\PaymentMethods\Interfaces\ITokenizable;
use GlobalPayments\Api\ServiceConfigs\Gateways\GpApiConfig;
use GlobalPayments\Api\Utils\CountryUtils;
use GlobalPayments\Api\Utils\GenerationUtils;
use GlobalPayments\Api\Utils\StringUtils;

class GpApiSecure3DRequestBuilder implements IRequestBuilder
{
    public static function canProcess($builder)
    {
        if ($builder instanceof Secure3dBuilder) {
            return true;
        }

        return false;
    }

    public function buildRequest(BaseBuilder $builder, $config)
    {
        $requestData = null;
        switch ($builder->transactionType)
        {
            case TransactionType::VERIFY_ENROLLED:
                $verb = 'POST';
                $endpoint = GpApiRequest::AUTHENTICATIONS_ENDPOINT;
                $requestData = $this->verifyEnrolled($builder, $config);
                break;
            case TransactionType::INITIATE_AUTHENTICATION:
                $verb = 'POST';
                $endpoint = GpApiRequest::AUTHENTICATIONS_ENDPOINT . "/{$builder->getServerTransactionId()}/initiate";
                $requestData = $this->initiateAuthenticationData($builder, $config);
                break;
            case  TransactionType::VERIFY_SIGNATURE:
                $verb = 'POST';
                $endpoint = GpApiRequest::AUTHENTICATIONS_ENDPOINT . "/{$builder->getServerTransactionId()}/result";
                if (!empty($builder->getPayerAuthenticationResponse())) {
                    $requestData['three_ds'] = [
                        'challenge_result_value' => $builder->getPayerAuthenticationResponse()
                    ];
                }
                break;
            default:
                 return null;
        }

        return new GpApiRequest(
            $endpoint,
            $verb,
            $requestData
        );
    }

    private function verifyEnrolled(Secure3dBuilder $builder, GpApiConfig $config)
    {
        $threeDS = [];
        $threeDS['account_name'] = $config->accessTokenInfo->transactionProcessingAccountName;
        $threeDS['channel'] = $config->channel;
        $threeDS['country'] = $config->country;
        $threeDS['reference'] = !empty($builder->referenceNumber) ? $builder->referenceNumber : GenerationUtils::getGuid();
        $threeDS['amount'] = StringUtils::toNumeric($builder->amount);
        $threeDS['currency'] = $builder->currency;
        $threeDS['preference'] = $builder->challengeRequestIndicator;
        $threeDS['source'] = (string) $builder->authenticationSource;
        $threeDS['payment_method'] = $this->setPaymentMethodParam($builder->paymentMethod);
        $threeDS['notifications'] = [
            'challenge_return_url' => $config->challengeNotificationUrl,
            'three_ds_method_return_url' => $config->methodNotificationUrl,
            'decoupled_notification_url' => $builder->decoupledNotificationUrl ?? null
        ];
        if (!empty($builder->storedCredential)) {
            $this->setStoreCredentialParam($builder->storedCredential, $threeDS);
        }

        return $threeDS;
    }

    private function initiateAuthenticationData(Secure3dBuilder $builder, GpApiConfig $config)
    {
        $threeDS['three_ds'] = [
            'source' => (string) $builder->authenticationSource,
            'preference' => $builder->challengeRequestIndicator,
            'message_version' => $builder->threeDSecure->messageVersion,
            'message_category' => EnumMapping::mapMessageCategory(GatewayProvider::GP_API, $builder->messageCategory)
        ];

        if (!empty($builder->storedCredential)) {
            $this->setStoreCredentialParam($builder->storedCredential, $threeDS);
        }
        $threeDS['method_url_completion_status'] = (string) $builder->methodUrlCompletion;
        $threeDS['merchant_contact_url'] = $config->merchantContactUrl;
        $order = [
            'time_created_reference' => !empty($builder->orderCreateDate) ?
                (new \DateTime($builder->orderCreateDate))->format('Y-m-d\TH:i:s.u\Z') : null,
            'amount' => StringUtils::toNumeric($builder->amount),
            'currency' => $builder->currency,
            'reference' => $builder->referenceNumber,
            'address_match_indicator' => $builder->isAddressMatchIndicator() ? true : false,
            'gift_card_count' => $builder->giftCardCount,
            'gift_card_currency'=> $builder->giftCardCurrency,
            'gift_card_amount' => $builder->giftCardAmount,
            'delivery_email' => $builder->deliveryEmail,
            'delivery_timeframe' => $builder->deliveryTimeframe,
            'shipping_method' => (string) $builder->shippingMethod,
            'shipping_name_matches_cardholder_name' => $builder->getShippingNameMatchesCardHolderName(),
            'preorder_indicator' => (string) $builder->preOrderIndicator,
            'preorder_availability_date' => !empty($builder->preOrderAvailabilityDate) ?
                (new \DateTime($builder->preOrderAvailabilityDate))->format('Y-m-d') : null,
            'reorder_indicator' => (string) $builder->reorderIndicator,
            'transaction_type' => $builder->orderTransactionType
        ];

        if (!empty($builder->shippingAddress)) {
            $order['shipping_address'] = [
                'line1' => $builder->shippingAddress->streetAddress1,
                'line2' => $builder->shippingAddress->streetAddress2,
                'line3' => $builder->shippingAddress->streetAddress3,
                'city' => $builder->shippingAddress->city,
                'postal_code' => $builder->shippingAddress->postalCode,
                'state' => $builder->shippingAddress->state,
                'country' => CountryUtils::getNumericCodeByCountry($builder->shippingAddress->countryCode)
            ];
        }
        $threeDS['order'] = $order;
        $threeDS['payment_method'] = $this->setPaymentMethodParam($builder->paymentMethod);
        $threeDS['payer'] = [
            'reference' => $builder->customerAccountId,
            'account_age' => (string) $builder->accountAgeIndicator,
            'account_creation_date' => !empty($builder->accountCreateDate) ?
                (new \DateTime($builder->accountCreateDate))->format('Y-m-d') : null,
            'account_change_date' => !empty($builder->accountChangeDate) ?
                (new \DateTime($builder->accountChangeDate))->format('Y-m-d') : null,
            'account_change_indicator' => (string) $builder->accountChangeIndicator,
            'account_password_change_date' => !empty($builder->passwordChangeDate) ?
                (new \DateTime($builder->passwordChangeDate))->format('Y-m-d') : null,
            'account_password_change_indicator' => (string) $builder->passwordChangeIndicator,
            'home_phone' => [
                'country_code' => $builder->homeCountryCode,
                'subscriber_number' => $builder->homeNumber
            ],
            'work_phone' => [
                'country_code' => $builder->workCountryCode,
                'subscriber_number' => $builder->workNumber
            ],
            'mobile_phone' => [
                'country_code' => $builder->mobileCountryCode,
                'subscriber_number' => $builder->mobileNumber
            ],
            'payment_account_creation_date' => !empty($builder->paymentAccountCreateDate) ?
                (new \DateTime($builder->paymentAccountCreateDate))->format('Y-m-d') : null,
            'payment_account_age_indicator' => (string) $builder->paymentAgeIndicator,
            'suspicious_account_activity' => $builder->previousSuspiciousActivity,
            'purchases_last_6months_count' => $builder->numberOfPurchasesInLastSixMonths,
            'transactions_last_24hours_count' => $builder->numberOfTransactionsInLast24Hours,
            'transaction_last_year_count' => $builder->numberOfTransactionsInLastYear,
            'provision_attempt_last_24hours_count' => $builder->numberOfAddCardAttemptsInLast24Hours,
            'shipping_address_time_created_reference' => !empty($builder->shippingAddressCreateDate) ?
                (new \DateTime($builder->shippingAddressCreateDate))->format('Y-m-d') : null,
            'shipping_address_creation_indicator' => (string) $builder->shippingAddressUsageIndicator
        ];
        if (!empty($builder->billingAddress)) {
            $threeDS['payer']['billing_address'] = [
                'line1' => $builder->billingAddress->streetAddress1,
                'line2' => $builder->billingAddress->streetAddress2,
                'line3' => $builder->billingAddress->streetAddress3,
                'city' => $builder->billingAddress->city,
                'postal_code' => $builder->billingAddress->postalCode,
                'state' => $builder->billingAddress->state,
                'country' => CountryUtils::getNumericCodeByCountry($builder->billingAddress->countryCode)
            ];
        }

        $threeDS['payer_prior_three_ds_authentication_data'] = [
            'authentication_method' => (string) $builder->priorAuthenticationMethod,
            'acs_transaction_reference' => $builder->priorAuthenticationTransactionId,
            'authentication_timestamp' => !empty($builder->priorAuthenticationTimestamp) ?
                (new \DateTime($builder->priorAuthenticationTimestamp))->format('Y-m-d\TH:i:s.u\Z') : null,
            'authentication_data' => $builder->priorAuthenticationData
        ];

        $threeDS['recurring_authorization_data'] = [
            'max_number_of_instalments' => $builder->maxNumberOfInstallments,
            'frequency' => $builder->recurringAuthorizationFrequency,
            'expiry_date' => $builder->recurringAuthorizationExpiryDate
        ];

        $threeDS['payer_login_data'] = [
            'authentication_data' => $builder->customerAuthenticationData,
            'authentication_timestamp' => !empty($builder->customerAuthenticationTimestamp) ?
                (new \DateTime($builder->customerAuthenticationTimestamp))->format('Y-m-d\TH:i:s.u\Z') : null,
            'authentication_type' => (string) $builder->customerAuthenticationMethod
        ];

        if (!empty($builder->browserData) && $builder->authenticationSource != AuthenticationSource::MOBILE_SDK) {
            $threeDS['browser_data'] = [
                'accept_header' => $builder->browserData->acceptHeader,
                'color_depth' => (string) $builder->browserData->colorDepth,
                'ip' => $builder->browserData->ipAddress,
                'java_enabled' => $builder->browserData->javaEnabled,
                'javascript_enabled' => $builder->browserData->javaScriptEnabled,
                'language' => $builder->browserData->language,
                'screen_height' => $builder->browserData->screenHeight,
                'screen_width' => $builder->browserData->screenWidth,
                'challenge_window_size' => (string) $builder->browserData->challengWindowSize,
                'timezone' => (string) $builder->browserData->timeZone,
                'user_agent' => $builder->browserData->userAgent
            ];
        }
        if (!empty($builder->mobileData) && $builder->authenticationSource == AuthenticationSource::MOBILE_SDK) {
            $threeDS['mobile_data'] = [
                'encoded_data' => $builder->mobileData->encodedData,
                'application_reference' => $builder->mobileData->applicationReference,
                'sdk_interface' => $builder->mobileData->sdkInterface,
                'sdk_ui_type' => EnumMapping::mapSdkUiType(GatewayProvider::GP_API, $builder->mobileData->sdkUiTypes),
                'ephemeral_public_key' => json_decode($builder->mobileData->ephemeralPublicKey),
                'maximum_timeout' => $builder->mobileData->maximumTimeout,
                'reference_number' => $builder->mobileData->referenceNumber,
                'sdk_trans_reference' => $builder->mobileData->sdkTransReference
            ];
        }
        $threeDS['notifications'] = [
            'decoupled_notification_url' => $builder->decoupledNotificationUrl ?? null
        ];
        if (isset($builder->decoupledFlowRequest)) {
            $threeDS['decoupled_flow_request'] = $builder->decoupledFlowRequest === true ? DecoupledFlowRequest::DECOUPLED_PREFERRED :
                DecoupledFlowRequest::DO_NOT_USE_DECOUPLED;
        }
        $threeDS['decoupled_flow_timeout'] = $builder->decoupledFlowTimeout ?? null;

        return $threeDS;
    }

    private function setPaymentMethodParam($cardData)
    {
        $paymentMethod = new PaymentMethod();
        if ($cardData instanceof ITokenizable && !empty($cardData->token)) {
            $paymentMethod->id = $cardData->token;

        }
        if ($cardData instanceof ICardData) {
            $paymentMethod->card = (object) [
                'number' => $cardData->number,
                'expiry_month' => !empty($cardData->expMonth) ? $cardData->expMonth : '',
                'expiry_year' => !empty($cardData->expYear) ?
                    substr(str_pad($cardData->expYear, 4, '0', STR_PAD_LEFT), 2, 2) : ''
            ];;
        }
        $paymentMethod->name = !empty($cardData->cardHolderName) ? $cardData->cardHolderName : null;

        return $paymentMethod;
    }


    /**
     * Set the stored credential details in the request
     *
     * @param StoredCredential $storedCredential
     * @param array $threeDS
     */
    private function setStoreCredentialParam($storedCredential, &$threeDS)
    {
        $initiator = EnumMapping::mapStoredCredentialInitiator(GatewayProvider::GP_API, $storedCredential->initiator);
        $threeDS['initiator'] = !empty($initiator) ? $initiator : null;
        $threeDS['stored_credential'] = [
            'model' => strtoupper($storedCredential->type),
            'reason' => strtoupper($storedCredential->reason),
            'sequence' => strtoupper($storedCredential->sequence)
        ];
    }
}