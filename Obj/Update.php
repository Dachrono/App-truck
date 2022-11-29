<?php

  include "Conexion.php";
  include "Encryp.php";

  $company = $nombre = $telefono = $email = $addrss = $zcode = $ciudad = $estado = "";

  $id = $_SESSION['Id'];
  $condicion=true;

  $expresiones=[
    "company" => "/^[a-zA-ZÀ-ÿ\s]{1,45}$/",
    "nombre" => "/^[a-zA-ZÀ-ÿ\s]{1,45}$/",
    "telefono" => "/^\d{7,11}$/",
    "correo" => "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/",
    "direccion" => "/^[a-zA-ZÀ-ÿ0-9.#\s]{1,45}$/",
    "z_code" => "/^\d{5}$/",
    "ciudad" => "/^[a-zA-ZÀ-ÿ\s]{1,45}$/",
    "estado" => "/^[a-zA-ZÀ-ÿ\s]{1,45}$/"
  ];

  if(isset($_POST["actualizar"]))
  {
    $company=$_POST["company"];
    $nombre=$_POST["nombre"];
    $telefono=$_POST["telefono"];
    $email=$_POST["email"];
    $addrss=$_POST["addrss"];
    $zcode=$_POST["cod_postal"];
    $ciudad=$_POST["ciudad"];
    $estado=$_POST["estado"];

    foreach($_POST as $campo=>$valor)
    {
      if(empty($valor)){
        $condicion=true;
        echo "<p>El campo '$campo' está vacio.</p>";
        break;
      }
      $condicion=false;//Ya se le da permiso a hacer la actualización.
    }

    //Validaciones pero ahora desde el servidor.
    if (!preg_match($expresiones["company"], $company)) {
      $condicion=true;
    }
    if (!preg_match($expresiones["nombre"], $nombre)) {
      $condicion=true;
    }
    if (!preg_match($expresiones["telefono"], $telefono)) {
      $condicion=true;
    }
    if (!preg_match($expresiones["correo"], $email)) {
      $condicion=true;
    }
    if (!preg_match($expresiones["direccion"], $addrss)) {
      $condicion=true;
    }
    if (!preg_match($expresiones["z_code"], $zcode)) {
      $condicion=true;
    }
    if (!preg_match($expresiones["ciudad"], $ciudad)) {
      $condicion=true;
    }
    if (!preg_match($expresiones["estado"], $estado)) {
      $condicion=true;
    }
  }

  if (!$condicion)
  {
    $nombre = $Encriptar($nombre);
    $_SESSION['Nombre'] = $nombre;
    $accion1 = "UPDATE cliente SET company='$company' ,full_name='$nombre',phone='$telefono', mail='$email' WHERE IDcliente='$id'";
    $accion2 = "UPDATE cliente_add SET Address='$addrss' ,zcode='$zcode',city='$ciudad',state='$estado' WHERE IDcliente='$id'";
    $resultado1= mysqli_query($conex, $accion1);
    $resultado2= mysqli_query($conex, $accion2);

    echo "<p id='exito'>¡Update Done!<p>";
    echo "<script>setTimeout(function(){document.getElementById('exito').innerHTML = '';}, 4000);</script>";
  }

  if (true)
  {
    include "Conexion.php";

    $consulta = mysqli_query($conex, "SELECT * from cliente where IDcliente='$id';");
    $consulta2 = mysqli_query($conex, "SELECT * from cliente_add where IDcliente='$id';");
    $datos = array_merge(mysqli_fetch_array($consulta), mysqli_fetch_array($consulta2));

    $val0 = $datos['company'];
    $val1 = $Desencriptar($datos['full_name']);
    $val2 = $datos['phone'];
    $val3 = $datos['mail'];
    $val4 = $datos['Address'];
    $val5 = $datos['zcode'];
    $val6 = $datos['city'];
    $val7 = $datos['state'];
    echo "<script>
    document.getElementById('company').value='$val0';
    document.getElementById('nombre').value='$val1';
    document.getElementById('telefono').value='$val2';
    document.getElementById('email').value='$val3';
    document.getElementById('addrss').value='$val4';
    document.getElementById('cod_postal').value='$val5';
    document.getElementById('ciudad').value='$val6';
    document.getElementById('estado').value='$val7';
    </script>";
  }

 ?>
