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

    <script>//Modelos y marcas
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
            <input class="inp" placeholder="State" oninput="this.className = ''" name="statecar" style="width: 40%">&emsp;&emsp;
            <input class="inp" placeholder="Plate" oninput="this.className = ''" name="plate" style="width: 40%">
          </p>
          <h5>Vehicle Type</h5>
          <p>
            <input class="inp" type="radio" oninput="this.className = ''" name="typetruck" value="truck"> Truck
            <input class="inp" type="radio" oninput="this.className = ''" name="typetruck" value="trailer"> Trailer
            <select style="margin: 10px" class="inp" id="mark" name="make">
              <option value="">--Select--</option>
            </select>
          </p>
          <p>
            <input placeholder="Model" name="model" required style="width: 40%">&emsp;&emsp;
            <input class="inp" type="number" placeholder="Year" oninput="this.className = ''" name="year" style="width: 40%">
          </p>
          <p>
            <input class="inp" placeholder="Unit #" oninput="this.className = ''" name="unit" style="width: 30%">&emsp;&emsp;&emsp;
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
