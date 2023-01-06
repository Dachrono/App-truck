<?php
include 'Conexion.php';
include 'Encryp.php';
include 'BackMail/SenderEmail.php';

$email = $_POST["email"];
$empresa = $_POST["company"];
$fullname = $Encriptar($_POST["fname"] ." " .$_POST["lname"]);
$telef = $_POST["phone"];

$usuario = $_POST["user"];
$pass = $Encriptar($_POST["pass"]);
$estatus = "Act";

$idunit = $_POST["unit"];
$edotruck = $_POST["statecar"];
$placa = $_POST["plate"];
$tipotruck = $_POST["typetruck"];
$yeartruck = $_POST["year"];
$marca = $_POST["make"];
$modelo = $_POST["model"];
$colortruck = $_POST["color"];
$act = 1;

if (empty($_POST["vin"]))
{
  $VIN = "Sin datos";
}
else
{
  $VIN = $_POST["vin"];
}

$add = "Sin datos";
$city = "Sin datos";
$state = "Sin datos";
$zcode = "12345";

$orden = $conex->prepare("INSERT INTO cliente (company,full_name,phone,mail) values (?,?,?,?)");
$orden->bind_param("ssss", $empresa,$fullname,$telef,$email);
$orden->execute();

$sql = "select IDcliente from cliente where mail = '$email' and '$telef' = phone";
$result = mysqli_query($conex, $sql);
$row = mysqli_fetch_array($result);
$idcliente = $row["IDcliente"];

$orden = $conex->prepare("INSERT INTO usuarios (idcliente,usuario,contrasena,estatus) values (?,?,?,?)");
$orden->bind_param("ssss", $idcliente,$usuario,$pass,$estatus);
$orden->execute();

$orden = $conex->prepare("INSERT INTO cliente_add (idcliente,address,city,state,zcode) values (?,?,?,?,?)");
$orden->bind_param("sssss", $idcliente,$add,$city,$state,$zcode);
$orden->execute();

$orden = $conex->prepare("INSERT INTO trucks (IDcliente,IDmarca,state,Vin,plate,Unit,Vehicle_type,year,model,color,act) values (?,?,?,?,?,?,?,?,?,?,?)");
$orden->bind_param("sssssssssss", $idcliente,$marca,$edotruck,$VIN,$placa,$idunit,$tipotruck,$yeartruck,$modelo,$colortruck,$act);
$orden->execute();

CorreoClienteNuevo($email, $fullname, $usuario, $pass);

Control($idcliente, $fullname, $email);

echo '<script language="javascript">alert("Successful registration"); window.location.href="../PagPrin.php"</script>';

?>
