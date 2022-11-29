<?php
  include "BodyMail.php";

  function CorreoClienteNuevo($email, $fullname, $usuario, $pass)
  {
    include 'Encryp.php';
    include "Mail.php";
    
    $FuNa = $Desencriptar($fullname);
    $Pas = $Desencriptar($pass);

    $mail->Subject = "Welcome to the TruckSavers app";
    $mail->Body = BodyClienteNuevo($FuNa, $usuario, $Pas);
    $mail->AddAddress("$email");
    $mail->Send();

  }

  function CorreoCita($email, $name, $servicio, $unidad, $fecha, $hora)
  {
    include "Mail.php";

    $mail->Subject = "Add to waiting list successful";
    $mail->Body = BodyCita($name, $servicio, $unidad, $fecha, $hora);
    $mail->AddAddress("$email");
    $mail->Send();
  }

  function CorreoTaller($name, $fecha, $hora, $servicio, $unidad, $millas, $aceite, $null, $mensaje, $f_aire, $GreaseS, $aditivo, $notas)
  {
    include "Mail.php";

    $mail->Subject = "$name Send request to visit the taller";
    $mail->Body = BodyTaller($name, $fecha, $hora, $servicio, $unidad, $millas, $aceite, $null, $mensaje, $f_aire, $GreaseS, $aditivo, $notas);
    $mail->AddAddress("inventory@qualitymultiserv.com");
    $mail->addBCC('dachrono@hotmail.com');
    $mail->Send();
}

  function Control($idcliente, $fullname, $email)
  {
    include "Encryp.php";
    include "Mail.php";

    $nom = $Desencriptar($fullname);

    $mail->Subject = "Cliente nuevo registrado en la app";
    $mail->Body = "Informacion del cliente en la plataforma <br><br> Id cliente: $idcliente <br><br> Nombre: $nom <br><br> Correo: $email";
    $mail->AddAddress("dachrono@hotmail.com");
    $mail->Send();

  }

?>
