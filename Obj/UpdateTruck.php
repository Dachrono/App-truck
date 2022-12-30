<?php
  session_start();
  
  if (!empty($_POST["NumUnit"]))
  {
    $_SESSION['IdUnit'] = $_POST["NumUnit"];
  }

?>

<html>
  <head>
    <title>Formulario</title>
    <meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../css/UpdateTruck.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  </head>

  <body>

    <header>
      <h1 id="titulo">Update Unit Information.</h1>
    </header>

      <form id="formulario" method="post">

          <div id="grupo_make">
            <label for="make" class="formulario_label">Unit make description:</label>
            <div style="display: flex">
              <input class="entrada" type="text" id="make" name="make" placeholder="Make" value="" readonly>
            </div>
          </div>

          <div id="grupo_state">
            <label for="state" class="formulario_label">State:</label>
            <div style="display: flex">
              <input class="entrada" type="text" id="state" name="state" placeholder="State" value="">
            </div>
          </div>

          <div id="grupo_year">
            <label for="year" class="formulario_label">Year:</label>
            <div style="display: flex">
              <input class="entrada" type="text" id="year" name="year" placeholder="Year">
            </div>
          </div>

          <div id="grupo_unit">
            <label for="unit" class="formulario_label">Unit:</label>
            <div style="display: flex">
              <input class="entrada" type="text" id="unit" name="unit" placeholder="Unit">
            </div>
          </div>

          <div id="grupo_plate">
            <label for="plate" class="formulario_label">Plate:</label>
            <div style="display: flex">
              <input class="entrada" type="text" id="plate" name="plate" placeholder="Plate">
            </div>
          </div>

          <div id="grupo_vin">
            <label for="vin" class="formulario_label">Vehicle identification number:</label>
            <div style="display: flex">
              <input class="entrada" type="text" id="vin" name="vin" placeholder="Vin">
            </div>
          </div>

          <div id="grupo_color">
            <label for="color" class="formulario_label">Color:</label>
            <div style="display: flex">
              <select id="color" name="color">
               <option value="White">White</option>
               <option value="Black">Black</option>
               <option value="Red">Red</option>
               <option value="Blue">Blue</option>
               <option value="Orange">Orange</option>
               <option value="Brown">Brown</option>
               <option value="Gray">Gray</option>
              </select>
            </div>
          </div>

          <br><br>
          <div id="grupo_eliminar">
            <label for="eliminar" class="formulario_label">If you like erase your unit write Er4se and click update</label>
            <div style="display: flex">
             <input class="entrada" type="text" id="erase" name="erase" placeholder="¡¡ This action can not be reversed. !!">
            </div>
          </div>

          <br>

          <div id="boton-centrar">
            <input id="boton" type="submit" name="actualizar" value="Update">
          </div>

          <?php
            include "UpdateUnit.php";
          ?>

      </form>

      <form action="../Main.php">
        <button type="submit";>Back</button>
      </form>

  </body>
</html>
