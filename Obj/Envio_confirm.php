<?php
 session_start();

 include 'Conexion.php';
 include 'BackMail/SenderEmail.php';

 $id = $_SESSION['Id'];

 $name = $_POST["Nombre"];
 $unidad = $_POST['Unidad'];
 $millas = $_POST['Millas'];
 $servicio = $_POST['Servicio'];
 $aceite = $_POST['Aceite'];
 $fecha = $_POST['Fecha'];
 $hora = $_POST['Hora'];
 $f_aire = $_POST["Ad1"];
 $GreaseS = $_POST["Ad2"];
 $aditivo = $_POST["Ad3"];
 $notas = $_POST["Ad4"];

 $sql = "select * from cliente where '$id' = IDcliente ";
 $result = mysqli_query($conex, $sql);
 $row = mysqli_fetch_array($result);
 $mail = $row['mail'];

 $idservi = "";
 $sql = "select idservicio from servicio where Descripcion = '$servicio'";
 $result = mysqli_query($conex, $sql);
 $row = mysqli_fetch_array($result);
 $idservi = $row['idservicio'];

 $mensaje = null;
 $null = null;
 if ($f_aire == null && $GreaseS == null && $aditivo == null && $notas == null)
 {
   $null = "No solicito ningun adicional";
 }
 else
 {
  $mensaje = "El cliente solicito como adicional: ";
  $adic = $f_aire . " - " . $GreaseS . " - " . $aditivo . " - " . $notas;
 }

 CorreoCita($mail, $name, $servicio, $unidad, $fecha, $hora);

 CorreoTaller($name, $fecha, $hora, $servicio, $unidad, $millas, $aceite, $null, $mensaje, $f_aire, $GreaseS, $aditivo, $notas);

 $orden = $conex -> prepare("INSERT INTO registro_serv (idcliente, unidad, fecha, hora, idservicio, adicionales) values (?,?,?,?,?,?)");
 $orden->bind_param("ssssss", $id,$unidad,$fecha,$hora,$idservi,$adic);
 $orden->execute();

 echo '<script language="javascript">alert("Registro creado con exito"); window.location.href="../PagPrin.php"</script>';

?>
