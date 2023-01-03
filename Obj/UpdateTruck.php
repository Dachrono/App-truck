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
              <select id="state" name="state">
                <option id=0 value="Sin datos">- Select state -</option>
                <option id=1 value="Alabama (AL)">Alabama (AL)</option>
                <option id=2 value="Alaska (AK)">Alaska (AK)</option>
                <option id=3 value="Arizona (AZ)">Arizona (AZ)</option>
                <option id=4 value="Arkansas (AR)">Arkansas (AR)</option>
                <option id=5 value="California (CA)">California (CA)</option>
                <option id=6 value="Carolina del Norte (NC)">Carolina del Norte (NC)</option>
                <option id=7 value="Carolina del Sur (SC)">Carolina del Sur (SC)</option>
                <option id=8 value="Colorado (CO)">Colorado (CO)</option>
                <option id=9 value="Connecticut (CT)">Connecticut (CT)</option>
                <option id=10 value="Dakota del Norte (ND)">Dakota del Norte (ND)</option>
                <option id=11 value="Dakota del Sur (SD)">Dakota del Sur (SD)</option>
                <option id=12 value="Delaware (DE)">Delaware (DE)</option>
                <option id=13 value="Florida (FL)">Florida (FL)</option>
                <option id=14 value="Georgia (GA)">Georgia (GA)</option>
                <option id=15 value="Hawái (HI)">Hawái (HI)</option>
                <option id=16 value="Idaho (ID)">Idaho (ID)</option>
                <option id=17 value="Illinois (IL)">Illinois (IL)</option>
                <option id=18 value="Indiana (IN)">Indiana (IN)</option>
                <option id=19 value="Iowa (IA)">Iowa (IA)</option>
                <option id=20 value="Kansas (KS)">Kansas (KS)</option>
                <option id=21 value="Kentucky (KY)">Kentucky (KY)</option>
                <option id=22 value="Luisiana (LA)">Luisiana (LA)</option>
                <option id=23 value="Maine (ME)">Maine (ME)</option>
                <option id=24 value="Maryland (MD)">Maryland (MD)</option>
                <option id=25 value="Massachusetts (MA)">Massachusetts (MA)</option>
                <option id=26 value="Míchigan (MI)">Míchigan (MI)</option>
                <option id=27 value="Minnesota (MN)">Minnesota (MN)</option>
                <option id=28 value="Misisipi (MS)">Misisipi (MS)</option>
                <option id=29 value="Misuri (MO)">Misuri (MO)</option>
                <option id=30 value="Montana (MT)">Montana (MT)</option>
                <option id=31 value="Nebraska (NE)">Nebraska (NE)</option>
                <option id=32 value="Nevada (NV)">Nevada (NV)</option>
                <option id=33 value="Nueva Jersey (NJ)">Nueva Jersey (NJ)</option>
                <option id=34 value="Nueva York (NY)">Nueva York (NY)</option>
                <option id=35 value="Nuevo Hampshire (NH)">Nuevo Hampshire (NH)</option>
                <option id=36 value="Nuevo México (NM)">Nuevo México (NM)</option>
                <option id=37 value="Ohio (OH)">Ohio (OH)</option>
                <option id=38 value="Oklahoma (OK)">Oklahoma (OK)</option>
                <option id=39 value="Oregón (OR)">Oregón (OR)</option>
                <option id=40 value="Pensilvania (PA)">Pensilvania (PA)</option>
                <option id=41 value="Rhode Island (RI)v">Rhode Island (RI)</option>
                <option id=42 value="Tennessee (TN)">Tennessee (TN)</option>
                <option id=43 value="Texas (TX)">Texas (TX)</option>
                <option id=44 value="Utah (UT)">Utah (UT)</option>
                <option id=45 value="Vermont (VT)">Vermont (VT)</option>
                <option id=46 value="Virginia (VA)">Virginia (VA)</option>
                <option id=47 value="Virginia Occidental (WV)">Virginia Occidental (WV)</option>
                <option id=48 value="Washington (WA)">Washington (WA)</option>
                <option id=49 value="Wisconsin (WI)">Wisconsin (WI)</option>
                <option id=50 value="Wyoming (WY)">Wyoming (WY)</option>
              </select>    
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
