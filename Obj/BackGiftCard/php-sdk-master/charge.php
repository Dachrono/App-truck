<?php

require_once ('autoload_standalone.php');

use GlobalPayments\Api\PaymentMethods\GiftCard;
use GlobalPayments\Api\ServiceConfigs\Gateways\PorticoConfig;
use GlobalPayments\Api\ServicesContainer;
use GlobalPayments\Api\Entities\Transaction;

$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);


$config = new PorticoConfig();
$config->secretApiKey = 'skapi_cert_MTyMAQBiHVEAewvIzXVFcmUd2UcyBge_eCpaASUp0A';

ServicesContainer::configureService($config);

try {
    $card = new GiftCard();
    $card->number = $_GET["card-number"];

    echo "Tarjeta de regalo: " . json_encode($card);
    $response = $card->balanceInquiry()
                ->execute();
    echo "<br><br>balanceAmount: " . $response->balanceAmount . " pointsBalanceAmount: ".$response->pointsBalanceAmount;

    
    
    $response = $card->charge(5)
            ->withCurrency('USD')
            ->execute();

    echo "<br><br>Con cargo: " . $response->balanceAmount . " pointsBalanceAmount: ".$response->pointsBalanceAmount;

    $response = $card->rewards(15)
                ->execute();
    echo "<br><br>Con recarga: " . $response->balanceAmount . " pointsBalanceAmount: ".$response->pointsBalanceAmount;


    // $regresar = Transaction::fromId($transactionId)
    //             ->reverse(1)
    //             ->execute();


} catch (Exception $e) {
    echo $e->getMessage();
}
