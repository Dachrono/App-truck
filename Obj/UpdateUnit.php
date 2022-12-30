<?php

  include "Conexion.php";

  $idUnit = $_SESSION['IdUnit'];

  if(isset($_POST["actualizar"]))
  {
    $erase = $_POST["erase"];

    if($erase != "Er4se")
    {
      $idUnit = $_SESSION['IdUnit'];
      $state = $_POST["state"];
      $year = $_POST["year"];
      $unit = $_POST["unit"];
      $plate = $_POST["plate"];
      $vin = $_POST["vin"];
      $color = $_POST["color"];

      $accion = "UPDATE trucks SET Vin='$vin', state='$state', year='$year', Unit='$unit', plate='$plate', color='$color' WHERE IDunidad='$idUnit'";
      $resultado = mysqli_query($conex, $accion);

      echo "<p id='exito'>¡Update Done!<p>";
      echo "<script>
              setTimeout(function(){document.getElementById('exito').innerHTML = '';}, 4000);
            </script>";
    }
     else
    {
      $erase = 2;
      $accion = "UPDATE trucks SET act=$erase WHERE IDunidad='$idUnit'";
      $resultado = mysqli_query($conex, $accion);
      echo '<script language="javascript">
              alert("Unit erased succesfully");
              window.location.href="../Main.php"
            </script>';
    }  
 
  }

  if (true)
  {
    include "Conexion.php";

    $consulta = mysqli_query($conex, "SELECT * from trucks where IDunidad ='$idUnit';");
    $datos = mysqli_fetch_array($consulta);

    $val0 = $datos['IDmarca'];
    $val1 = $datos['model'];

    $consulta2 = mysqli_query($conex, "SELECT * from marca where IDmarca ='$val0';");
    $datos2 = mysqli_fetch_array($consulta2);

    $val2 = $datos2['descripcion'];
    $val3 = $datos2['type'];
    $val4 = $datos['state'];
    $val5 = $datos['year'];
    $val6 = $datos['Unit'];
    $val7 = $datos['plate'];
    $val8 = $datos['Vin'];
    $val9 = $datos['color'];

    $UnitType = $val2 . " " . $val1 . ", " . $val3;

    echo "<script>
    document.getElementById('make').value='$UnitType';
    document.getElementById('state').value='$val4';
    document.getElementById('year').value='$val5';
    document.getElementById('unit').value='$val6';
    document.getElementById('plate').value='$val7';
    document.getElementById('vin').value='$val8';
    document.getElementById('color').value='$val9';
    </script>";
  }

 ?>
