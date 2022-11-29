<?php
 include 'Obj/Encryp.php';
 session_start();

 $id = $_SESSION['Id'];
 $nombre = $Desencriptar($_SESSION['Nombre']);
 $unidad = $_POST['marcas'];
 $millaje =$_POST["kilometraje"];
 $aceite =$_POST["Aceite"];
 $fecha = $_POST["dia"];
 $servicio =$_POST["Servicios"];
 $hora = $_POST["hora"];
 $aditivo = $_POST["Ad_aceite"];

 $Ad1 =  $Ad2 = $Ad3 = $Ad4 = "";

  if (isset($_POST["filtro"]))
  {
    $Ad1 = $_POST["filtro"];
  }
  else
  {
    $Ad1 = null;
  }

  if (isset($_POST["Grease"]))
  {
    $Ad2 = $_POST["Grease"];
  }
  else
  {
    $Ad2 = null;
  }

  if ($aditivo != "1")
  {
    $Ad3 = $_POST["Ad_aceite"];
  }
  else
  {
    $Ad3 = null;
  }

  if (isset($_POST["Otros"]))
  {
    $Ad4 = $_POST["Otros"];
  }
  else
  {
    $Ad4 = null;
  }

?>

<html>
  <head>
    <title>TheTruckSavers</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Confirma.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">

  </head>
  <body>

  <div class="Encabezado">
    <img  src="img/LogoPrin2.png" alt="" />
    <span><b>SERVICE APPOINTMENT CONFIRMATION</b></span>
    <img  src="img/LogoPrin2.png" alt="" />
  </div>

  <hr>

  <div class="titulo">
    <span><b>SERVICE DATA</b></span>
  </div>

  <hr>

  <div class="formato">
      <form class="" action="Obj/Envio_confirm.php" method="POST">
        <table>
          <tr>
            <td class="espaciar"><span><b>CLIENT:</b> </span></td>
            <td><input name="Nombre" value="<?php echo $nombre ?>" readonly></td>
          </tr>
          <tr>
          <td class="espaciar"><span><b>BRAND AND PLATES:</b></span></td>
            <td><input name="Unidad" value="<?php echo $unidad ?>" readonly></td>
          </tr>
          <tr>
          <td class="espaciar"><span><b>MILEAGE:</b></span></td>
            <td><input name="Millas" value="<?php echo $millaje; ?>" readonly></td>
          </tr>
          <tr>
          <td class="espaciar"><span><b>SERVICE:</b></span></td>
            <td><input name="Servicio" value="<?php echo $servicio; ?>" readonly></td>
          </tr>
          <tr>
          <td class="espaciar"><span> <b>OIL:</b> </span></td>
            <td><input name="Aceite" value="<?php echo $aceite; ?>" readonly></td>
          </tr>
          <tr>
          <td class="espaciar"><span> <b>DATE:</b> </span></td>
            <td><input name="Fecha" value="<?php echo $fecha ?>" readonly></td>
          </tr>
          <tr>
          <td class="espaciar"><span> <b>TIME:</b> </span></td>
            <td><input name="Hora" value="<?php echo $hora ?> hrs" readonly></td>
          </tr>
        </table>
        <br>
        <span><b>ADDITIONAL:</b><br></span>
        <input class="adicional" name="Ad1" value="<?php echo $Ad1; ?>" readonly></input>
        <input class="adicional" name="Ad2" value="<?php echo $Ad2; ?>" readonly></input><br>
        <input class="adicional" name="Ad3" value="<?php echo $Ad3; ?>" readonly></input>
        <input class="adicional" name="Ad4" value="<?php echo $Ad4; ?>" readonly></input>
        <div>
          <br>
         <button class="puchar" type="submit" name="button">CONFIRM</button>
         <button class="puchar" type="button" name="la cage" onclick="location.href='Cita.php'">RETURN</button>
        </div>
      </form>
    </div>

  <hr>

  <div class="contenedor2">

    Remember to follow us on our social networks...<br>

    <div>
      <br><br>
      <a href="https://www.facebook.com/TheTruckSavers/" target="_blank"><img src="img/Redes/face.png"></a>
      <a href="https://www.tiktok.com/@thetrucksavers?" target="_blank"><img src="img/Redes/tik.png"></a>
      <a href="https://www.instagram.com/thetrucksavers/" target="_blank"><img src="img/Redes/int.png"></a>
      <a href="https://www.youtube.com/channel/UCNt6mtWisgfxaLwxjp2GGrg" target="_blank"><img src="img/Redes/you.png"></a>
      <a href="https://t.me/thetrucksavers" target="_blank"><img src="img/Redes/tele.png"></a>
      <br><br>
    </div>



  </div>

  <div class="contenedor3">

    <a href="https://goo.gl/maps/XwdBePetmBCNaouT6"><img src="img/Ubica.png" width="15px"> 1362 Sheffield Blvd, Houston, TX, United States</a>
    <a><img src="img/tel.png" width="15px"> 713-455-5566</a>
    <a>All rights reserved. The Truck Savers 2022</a>

  </div>

  </body>
</html>
