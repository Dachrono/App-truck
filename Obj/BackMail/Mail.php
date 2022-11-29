<?php
 require_once "PhpMailer/src/PHPMailer.php";
 require_once "PhpMailer/src/SMTP.php";
 
 $mail = new PHPMailer\PHPMailer\PHPMailer();
 $mail->IsSMTP(); // enable SMTP
 $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
 $mail->SMTPAuth = true; // authentication enabled
 $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
 $mail->Host = "smtp.titan.email"; //smtp.gmail.com //smtp.titan.email
 $mail->Port = 465; // or 587
 $mail->IsHTML(true);
 $mail->Username = "soporte@appthetrucksavers.com";
 $mail->Password = "Eslamisma";
 $mail->SetFrom("soporte@appthetrucksavers.com");
 
 //$mail->Subject = "Hola Andres";
 //$mail->Body = "Tratando de hacer funcionar esta mdr";
 //$mail->AddAddress("bluefire_andy@hotmail.com");
 //$mail->addCC('andres_zamorano_@hotmail.com');
 //$mail->addBCC('dachrono@hotmail.com');

 //if(!$mail->Send()) {
 //echo "Mailer Error: " . $mail->ErrorInfo;
 //} else {
 //echo "Mensaje enviado correctamente";
 //}
?>