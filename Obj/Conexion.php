<?php

//SERVER Xammp
/*
$serv = "127.0.0.1";
$usuario = "root";
$password = "";
$base = "trucksaver";
*/

//SERVER HOSTGATOR

$serv = "162.241.2.36";
$usuario = "appthetr_root";
$password = "Abcd1234";
$base = "appthetr_trucksaver";


//SERVER HOSTINGER
/*
$serv = "82.180.138.103";
$usuario = "u540349646_root";
$password = "hanna254C";
$base = "u540349646_trucksaver";
*/

$conex = mysqli_connect($serv, $usuario, $password, $base);

//mysqli_close($conex);
 ?>
