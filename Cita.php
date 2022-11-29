<?php
  include 'Obj/Conexion.php';
  include 'Obj/Encryp.php';
  session_start();

   $nombre = $_SESSION['Nombre'];
   $id = $_SESSION['Id'];
?>

<html>
  <head>
    <title>Lista de espera Truck savers</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/Cita.css" type="text/css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  </head>

<body>

  <div class="contenedor">

      <div class="Encabezado">
        <img  src="img/LogoPrin2.png" alt="" ></img>
        <span>Good Evening, <?php echo $Desencriptar($nombre); ?></span>
      </div>

      <div class="formato" >
        <form action="Confirma.php" method="POST">
          <table>
            <tr>
              <td style="padding-top: 20px;">
                <p>Select a unit:</p>
              </td>
              <td style="padding-top: 20px;">
                <select name="marcas">
                <option> - Select your unit - </option>
                  <?php
                    $sql1 = "SELECT trucks.Unit, trucks.color, marca.descripcion from trucks INNER JOIN marca on trucks.IDmarca = marca.IDmarca where IDcliente = $id";
                    $query = mysqli_query($conex, $sql1);

                    while ($row = mysqli_fetch_array($query))
                    {
                      $Marca = $row['descripcion'];
                      $Unit = $row['Unit'];
                      $Color = $row['color'];

                      echo "<option>" . $Unit ." - ". $Marca . " - " . $Color . "</option>";
                    }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <p>Service:</p>
              </td>
              <td>
                <select name="Servicios">
                  <?php
                    $sql2 = "select * from servicio";
                    $query1=mysqli_query($conex, $sql2);
                    while ($row1=mysqli_fetch_array($query1))
                    {
                      $serv = $row1['Descripcion'];
                      echo "<option>" . $serv . "</option>";
                    }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <p>Oil:</p>
              </td>
              <td>
                <select name="Aceite">
                  <?php
                    $sql3 = "select * from tipos_aceite";
                    $result=mysqli_query($conex, $sql3);
                    while ($row2=mysqli_fetch_array($result))
                    {
                      $aceite =$row2["descripcion"];
                      echo "<option>" . $aceite . "</option>";
                    }
                  ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <p>Date:</p>
              </td>
              <td>
                <?php
                  $date = date('m/d/Y');
                  echo "<input name='dia' value=". $date ." readonly></input>";
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <p>Arrival time:</p>
              </td>
              <td>
                <input type="time" name="hora" required>
              </td>
            </tr>
            <tr>
              <td>
                <p>Mileage:</p>
              </td>
              <td>
                <input type="number" name="kilometraje" placeholder="10000" size="8" required>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <p>ADDITIONAL</p>
              </td>
            </tr>
            <tr>
              <td>
                <p>Air Filter:</p>
              </td>
              <td><input type="checkbox" id="filtro" name="filtro" value="Filtro de Aire" ></td>
            </tr>
            <tr>
              <td>
                <p>Trailer Grease Job:</p>
              </td>
              <td><input type="checkbox" id="Grease" name="Grease" value="Trailer Grease Job" ></td>
            </tr>
            <tr>
              <td>
                <p>Oil additive:</p>
              </td>
              <td>
                <select name="Ad_aceite">
                  <option value="1">Select</option>
                  <option value="Aditivo Lucas">Lucas</option>
                  <option value="Aditivo Gonher">Gonher</option>
                </select>
            </td>
            </tr>
            <tr>
              <td colspan="2">
                <p>NOTES:</p>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <textarea name="Otros" rows="3" cols="35"></textarea>
              </td>
            </tr>
            <tr>
              <td>
                <button type="submit" name="button" class="puchar" id="aceptar"><b>ACCEPT</b></button>
              </td>
              <td>
                <button type="button" name="button" class="puchar" id="cancelar" onclick="location.href='Main.php'"><b>CANCEL</b></button>
              </td>
            </tr>
          </table>

        </form>
      </div>

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

    </div>

</body>
</html>
