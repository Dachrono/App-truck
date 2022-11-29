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
          <input placeholder="State" name="statecar" required style="width: 40%">&emsp;&emsp; </input>
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
