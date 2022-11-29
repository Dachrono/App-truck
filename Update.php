<?php
  session_start();
?>

<html>
  <head>
    <title>Formulario</title>
    <meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/Update.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  </head>

  <body>

    <header>
      <h1 id="titulo">Update Information.</h1>
    </header>

      <form id="formulario" method="post">

          <div id="grupo_company">
            <label for="company" class="formulario_label">Company Name:</label>
            <div style="display: flex">
              <input class="entrada" type="text" id="company" name="company" placeholder="Company name" value="">
              <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario_mensaje">Only letters and blanks.</p>
          </div>

          <div id="grupo_nombre">
            <label for="nombre" class="formulario_label">Full Name:</label>
            <div style="display: flex">
              <input class="entrada" type="text" id="nombre" name="nombre" placeholder="Full name" value="">
              <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario_mensaje">Only letters and blanks.</p>
          </div>

          <div id="grupo_telefono">
            <label for="telefono" class="formulario_label">Phone number:</label>
            <div style="display: flex">
              <input class="entrada" type="text" id="telefono" name="telefono" placeholder="Phone number">
              <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario_mensaje">Only 7 to 11 digits.</p>
          </div>

          <div id="grupo_email">
            <label for="email" class="formulario_label">Email:</label>
            <div style="display: flex">
              <input class="entrada" type="email" id="email" name="email" placeholder="Email">
              <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario_mensaje">Mail format not allowed.</p>
          </div>

          <div id="grupo_addrss">
            <label for="addrss" class="formulario_label">Address:</label>
            <div style="display: flex">
              <input class="entrada" type="text" id="addrss" name="addrss" placeholder="Address Line">
              <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario_mensaje">Only dots and number signs are allowed as symbols.</p>
          </div>

          <div id="grupo_cod_postal">
            <label for="cod_postal" class="formulario_label">Zip Code:</label>
            <div style="display: flex">
              <input class="entrada" type="text" id="cod_postal" name="cod_postal" placeholder="Zip Code">
              <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario_mensaje">Necessarily 5 digits</p>
          </div>

          <div id="grupo_ciudad">
            <label for="ciudad" class="formulario_label">City:</label>
            <div style="display: flex">
              <input class="entrada" type="text" id="ciudad" name="ciudad" placeholder="City">
              <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario_mensaje">Only letters and blanks.</p>
          </div>

          <div id="grupo_estado">
            <label for="estado" class="formulario_label">State:</label>
            <div style="display: flex">
              <input class="entrada" type="text" id="estado" name="estado" placeholder="State">
              <i class="formulario__validacion-estado fas fa-times-circle"></i>
            </div>
            <p class="formulario_mensaje">Only letters and blanks.</p>
          </div>

          <div id="boton-centrar">
            <input id="boton" type="submit" name="actualizar" value="Update">
          </div>

          <?php
            include "Obj/Update.php";
          ?>

      </form>

      <form action="Main.php">
        <button type="submit";>Back</button>
      </form>

      <script src="Obj/UpdateJS.js"></script>

  </body>
</html>
