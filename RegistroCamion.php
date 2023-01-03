<html>

  <head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/RegistroCamion.css">
    <title>New Vehicle</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>


    <script>//Marcas
      $(document).ready(function(){
        var consulta;
        $('input[name="typetruck"]').click(function () {
          consulta = $('input[name="typetruck"]:checked').val();

          $.ajax({
            url: "Obj/BuscaTruck.php",
            data: "tipomar="+consulta,
            type: "POST",
            success: function(data){
              $("#mark").html(data);
            }
          });
        });
      });
    </script>

  </head>

  <body>

    <div class="contenedor">
      <form id="regForm" action="Obj/InsertarCamion.php" method="post">
        <h2>NEW VEHICLE</h2>
        <p>
          <select name="statecar" required>
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
          <input placeholder="Plate" name="plate" required style="width: 40%"> </input>
        </p>
        <h5>Vehicle Type</h5>
          <p>
            <input type="radio" name="typetruck" required value="truck"> Truck
            <input type="radio" name="typetruck" required value="trailer"> Trailer
            <select style="margin: 10px" id="mark" name="make">
              <option value="">--Select type--</option>
            </select>
          </p>
          <p>
            <input placeholder="Model" name="model" required style="width: 40%">&emsp;&emsp;
            <input type="number" placeholder="Year" name="year" required style="width: 40%"></input>
          </p>
          <p>
            <input placeholder="Unit #" name="unit" required style="width: 30%">&emsp;&emsp;&emsp;
            <!--<input placeholder="Color" name="color" required style="width: 40%">>-->
            <select name="color">
              <option value="">--Select color--</option>
              <option value="White">White</option>
              <option value="Black">Black</option>
              <option value="Red">Red</option>
              <option value="Blue">Blue</option>
              <option value="Orange">Orange</option>
              <option value="Brown">Brown</option>
              <option value="Gray">Gray</option>
            </select>
          </p>
          <p>
            <input type="number" placeholder="VIN (Optional)" name="vin" style="width: 75%"> </input> </input> </input>
          </p>
          <p style="text-align: center">
              <button type="submit" name="acept">ADD</button>
              <button type="button" name="cancel" onclick="location.href='Main.php'">CANCEL</button>
          </p>
      </form>

    </div>

  </body>
</html>
