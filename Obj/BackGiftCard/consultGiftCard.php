<?php

require_once ('php-sdk-master/autoload_standalone.php');
include '../Conexion.php';

use GlobalPayments\Api\PaymentMethods\GiftCard;
use GlobalPayments\Api\ServiceConfigs\Gateways\PorticoConfig;
use GlobalPayments\Api\ServicesContainer;


$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
$config = new PorticoConfig();
$config->secretApiKey = 'skapi_cert_MTyMAQBiHVEAewvIzXVFcmUd2UcyBge_eCpaASUp0A';

ServicesContainer::configureService($config);

$datos= json_decode(file_get_contents("php://input"));
$id=$datos->id;
$cardNumber=intval($datos->cardNumber);

$finalNumber = null;



if($cardNumber!=-1){
    $finalNumber = $cardNumber;
}
else{
    /*codigo para saber si tiene cardNumber*/
    // $query = "select * from giftcard where '" .$id. "' = id";
    // $result = mysqli_query($conex, $query);
    // $row = mysqli_fetch_array($result);
    if(true){//Si encuentra registro
        $finalNumber = 5022440000000000098;//$row[0] o el dato del numero
    }
    else{
        echo 5678;//Reconocer que no lo encontró
    }
}

if($finalNumber != null){
    try{
        $card = new GiftCard();
        $card->number = $finalNumber;//$row[0]
    
        $response = $card->balanceInquiry()
                    ->execute();
    
        $arreglo=(array)$response;
        $arreglo["numeroTar"]=strval($finalNumber);//$row[0]
        echo json_encode($arreglo);
    
        // $response = $card->rewards(15)
        //         ->execute();
        // echo "\n\n\nCon recarga: " . json_encode($response);
        
        // $cargo = $card->charge(1)
        //         ->withCurrency('USD')
        //         ->execute();
    
        // echo "\n\nCon cargo: " . json_encode($cargo);
    
        // $regresar = Transaction::fromId($transactionId)
        //             ->reverse(1)
        //             ->execute();
    
    
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

    
?>