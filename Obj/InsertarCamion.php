<?php
  session_start();
  include 'Conexion.php';
  $idunit = $_POST["unit"];
  $idcliente = $_SESSION['Id'];
  $edotruck = $_POST["statecar"];
  $placa = $_POST["plate"];
  $tipotruck = $_POST["typetruck"];
  $yeartruck = $_POST["year"];
  $marca = $_POST["make"];
  $modelo = $_POST["model"];
  $colortruck = $_POST["color"];
  if (empty($_POST["vin"])) {
      $VIN = "Sin datos";
    }else {
      $VIN = $_POST["vin"];
    }

  $orden = $conex->prepare("INSERT INTO trucks (IDcliente,IDmarca,state,Vin,plate,Unit,Vehicle_type,year,model,color) values (?,?,?,?,?,?,?,?,?,?)");
  $orden->bind_param("ssssssssss", $idcliente,$marca,$edotruck,$VIN,$placa,$idunit,$tipotruck,$yeartruck,$modelo,$colortruck);

  if ($orden->execute()) {
    echo '<script language="javascript">alert("Successful registration");window.location.href="../Main.php"</script>';
  }else {
    echo '<script language="javascript">alert("Registration failed, please try again later")';
  }


?>
