<html>
  <head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/NuevoUsuario.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Adamina|Angkor|Belgrano">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <title>New Register</title>

    <script>//Comprobar usuario

      $(document).ready(function()
      {
        var consulta;
        var disponible =false;
        var disponibleCorreo = false;

        $("#User").focus(); //hacemos focus
        $("#User").keyup(function(e) //comprobamos si se pulsa una tecla
        { 
          $(`#resultadoUser`).html('<img width="35px" src="img/ajax.gif" />');
          consulta = $(`#User`).val(); //obtenemos el texto introducido en el campo
            $(`#resultadoUser`).delay(1000).queue(function(n) //hace la búsqueda
            {
              $.ajax({
                url: "Obj/BuscarUser.php",
                data: "usuario="+consulta,
                type: "POST",
                success: function(data)
                {
                  let ley = data == 1234 ? "Username available" : "Username don't available";
                  $(`#resultadoUser`).html(ley);
                  disponible = data == 1234 ? true : false;
                  console.log(data);
                  console.log(ley);
                  console.log(disponible);
                  n();
                },
                error: function()
                {
                  alert("error petición ajax");
                }
              });
            });
        });

        $("#Correo").keyup(function(e){ //comprobamos si se pulsa una tecla

          $("#resultadoCorreo").html('<img width="35px" src="img/ajax.gif" />');
          correo = $("#Correo").val(); //obtenemos el texto introducido en el campo
          $("#Correo").delay(1000).queue(function(n) //hace la búsqueda
          {
            $.ajax({
              url: "Obj/BuscarCorreo.php",
              data: "mail="+correo,
              type: "POST",
              success: function(data)
               {
                let ley = data == 1234 ? "Email available" : "Email don't available";
                $("#resultadoCorreo").html(ley);
                disponibleCorreo = data == 1234 ? true : false;
                console.log(data);
                console.log(ley);
                console.log(disponible);
                n();
              },
              error: function()
              {
                alert("error petición ajax");
              }
            });
          });
        });

          $("#nextBtn").on("click", function(e){
            if(disponible && disponibleCorreo){
              nextPrev(1);
            }else{
              e.preventDefault();
            }

          })
        });

    </script>

    <script>
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

    <script>
      function BuscaModelo()
      {
        var combo = document.getElementById("mark");
        //var selected = combo.options[combo.selectedIndex].text;
        var id = combo.options[combo.selectedIndex].value;

        $.ajax({
                url: "Obj/BuscaTruck.php",
                data: "IdMarca="+id,
                type: "POST",
                
                success: function(data)
                {
                  $("#model").html(data);
                }
          });
      }
    </script>

  </head>
  <body>

    <div class="contenedor">
      <form id="regForm" action="Obj/InsertaCliente.php" method="post">

        <div class="tab">
          <div class="curstep">
            <br>&emsp;&emsp;Step 1 of 2
            <button id="cancel" type="button" onclick="location.href='PagPrin.php'">CANCEL</button>
          </div>
          <h4>ACCOUNT INFORMATION</h4>
          <p><input class="inp" id="Correo" placeholder="Email" oninput="this.className = ''" name="email" style="width: 97%">
          <span id="resultadoCorreo"></span>
          </p>
          <p><input class="inp" placeholder="Company" oninput="this.className = ''" name="company" style="width: 97%"></p>
          <p>
            <input class="inp" placeholder="First Name" oninput="this.className = ''" name="fname" style="margin-right: 10px;">
            <input class="inp" placeholder="Last Name" oninput="this.className = ''" name="lname">
          </p>
          <p><input class="inp" type="number" placeholder="Phone Number" oninput="this.className = ''" name="phone" style="width: 95%"></p>
          <p>
            <input class="inp" id="User" placeholder="Username" oninput="this.className = ''" name="user" style="width: 95%">
            <br><span id="resultadoUser"></span>
          </p>
          <p>
            <input class="inp" type="password" id="showpass" placeholder="Password" oninput="this.className = ''" name="pass" style="width: 95%">
            <input class="inp" type="checkbox" onclick="viewpass()">Show password
          </p>
          <div class="special">
            <p><button type="button" id="nextBtn">NEXT STEP</button></p>
          </div>
        </div>

        <div class="tab">
          <div class="curstep">
            <br>&emsp;&emsp;Step 2 of 2
            <button id="cancel" type="button" onclick="location.href='PagPrin.php'">CANCEL</button>
          </div>
          <h4>VEHICLE INFORMATION</h4>
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
            <input class="inp" placeholder="Plate" oninput="this.className = ''" name="plate" style="width: 40%">
          </p>
          <h5>Vehicle Type
            <input class="inp" type="radio" oninput="this.className = ''" name="typetruck" value="truck"> Truck
            <input class="inp" type="radio" oninput="this.className = ''" name="typetruck" value="trailer"> Trailer
          </h5>  
          <p>
            <select style="margin: 10px" id="mark" name="make" onchange="BuscaModelo();">
              <option value="">--Select vehicle type--</option>
            </select>
            <select style="margin: 10px" id="model" name="model">&emsp;&emsp;
              <option value="">-- Select model --</option>
            </select>
          </p>
          <p>
            <input class="inp" type="number" placeholder="Year" oninput="this.className = ''" name="year" style="width: 40%">&emsp;&emsp;
            <input class="inp" placeholder="Unit #" oninput="this.className = ''" name="unit" style="width: 30%">&emsp;&emsp;&emsp;
            <br>
            <br>
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
            <input type="number" placeholder="VIN (Optional)" oninput="this.className = ''" name="vin" style="width: 75%"></p>
          <div class="special">
            <p>
              <button type="button" id="nextBtn" onclick="nextPrev(1)">ADD</button>
              <button type="button" id="prevBtn" onclick="nextPrev(-1)">PREVIOUS</button>
            </p>
          </div>
        </div>

      </form>

    </div>


      <script> // Acciones de formulario
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
          // This function will display the specified tab of the form...
          var x = document.getElementsByClassName("tab");
          x[n].style.display = "block";
          //... and fix the Previous/Next buttons:
          if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
          } else {
            document.getElementById("prevBtn").style.display = "inline";
          }
          if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit";
          } else {
            document.getElementById("nextBtn").innerHTML = "Next";
          }
        }

        function nextPrev(n) {
          // This function will figure out which tab to display
          var x = document.getElementsByClassName("tab");
          // Exit the function if any field in the current tab is invalid:
          if (n == 1 && !validateForm()) return false;
          // Hide the current tab:
          x[currentTab].style.display = "none";
          // Increase or decrease the current tab by 1:
          currentTab = currentTab + n;
          // if you have reached the end of the form...
          if (currentTab >= x.length) {
            // ... the form gets submitted:
            document.getElementById("regForm").submit();
            return false;
          }
          // Otherwise, display the correct tab:
          showTab(currentTab);
        }

        function validateForm() {
          // This function deals with validation of the form fields
          var x, y, i, valid = true;
          x = document.getElementsByClassName("tab");
          y = x[currentTab].getElementsByClassName("inp");
          // A loop that checks every input field in the current tab:
          for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].value == "") {
              // add an "invalid" class to the field:
              y[i].className += " invalid";
              // and set the current valid status to false
              valid = false;
            }
          }
          // If the valid status is true, mark the step as finished and valid:
          if (valid) {
            document.getElementsByClassName("tab")[currentTab].className += " finish";
          }
          return valid; // return the valid status
        }

        //SHOW PASSWORD
        function viewpass(){
          var x = document.getElementById("showpass");
          if (x.type === "password"){
            x.type = "text";
          }else{
            x.type = "password";
          }
        }
      </script>
  </body>
</html>
