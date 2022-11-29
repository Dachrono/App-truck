<?php

  include "Keys.php";

  $method = 'aes-256-cbc';

  $Desencriptar = function($Datos) use ($method, $Key, $iv_key)
  {
    $encrypted_data = base64_decode($Datos);
    return openssl_decrypt($Datos, $method, $Key, false, $iv_key);
  };

  $Encriptar = function($Datos) use ($method, $Key, $iv_key)
  {
    return openssl_encrypt ($Datos, $method, $Key, false, $iv_key);
  };

?>
