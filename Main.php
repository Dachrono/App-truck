<?php
  include 'Obj/Conexion.php';
  include 'Obj/Encryp.php';
  session_start();

  $nombre = $_SESSION['Nombre'];
  $id = $_SESSION['Id'];

  $sql = "SELECT * FROM cliente WHERE IDcliente = $id";
  $querry = mysqli_query($conex, $sql);
  $row = mysqli_fetch_array($querry);

  $Com = $row['company'];
  $Nam = $row['full_name'];
  $Tel = $row['phone'];
  $Ema = $row['mail'];

  $sql = "SELECT * FROM cliente_add WHERE IDcliente = $id";
  $querry = mysqli_query($conex, $sql);
  $row = mysqli_fetch_array($querry);

  $Add = $row['Address'];
  $Dir = $row['city'].", " .$row['state'];
  $Cod = $row['zcode'];
?>

<html>
<head>

  <title>Waiting list The Truck savers</title>

  <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="css/Main.css" type="text/css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="Js/TarjMem.js"></script>

</head>

<body>

  <div class="contenedor">

    <div class="Encabezado">
      <img  src="img/LogoPrin2.png"></img>
      <span>Welcome, <?php echo $Desencriptar($nombre); ?></span>
    </div>

    <div id="home" class="tabcontent">
      <a href="Cita.php">OIL CHANGE<br>WAITING LIST</a>
    </div>

    <div id="vehicles" class="tabcontent">
      <br>
      <?php
        $sql1 = "SELECT trucks.IDunidad, trucks.Unit, trucks.model, trucks.plate, trucks.Vin, marca.descripcion from trucks INNER JOIN marca on trucks.IDmarca = marca.Idmarca where trucks.IDcliente = $id and trucks.act=1";
        $query2 = mysqli_query($conex, $sql1);

        if ($query2->num_rows > 0)
        {
          echo "<table>
                <tr>
                <th width='22%'>Unit id</th>
                <th width='22%'>Make</th>
                <th width='22%'>Plate</th>
                <th width='22%'>Vin</th>
                <th width='12%'></th>
                </tr>";

          while ($row = mysqli_fetch_array($query2))
          {
           echo "<tr><form action='Obj/UpdateTruck.php' method='post'>
                 <td>" . $row['Unit'] . "</td>
                 <td>" . $row['descripcion']. ", " . $row['model'] . "</td>
                 <td>" . $row['plate'] . "</td>
                 <td>". $row['Vin'] ."</td>
                 <td>
                    <input hidden name='NumUnit' value=". $row['IDunidad'] .">
                    <button id='sub' type='submit'>Modify unit</button>
                 </td>      
                 </form></tr>";
          }
          echo "</table>";
        }
        else
        {
          echo "<p>There is not any unit</p>";
        }
      ?>

      <form action="RegistroCamion.php">
        <button id="Sub2" type="submit">Add</button>
      </form>

    </div>

    <div id="messages" class="tabcontent">
      <div class="contentMembership">

        <h2>Welcome to membership program please insert you card number</h2>

        <div class="adj">
          <div class="adj1">
            <label class="item" for="card-number">Card Number</label>
            <input type="number" name="cardnumber" id="cardnumber" class="inputMembership" required>
            <button class="item" id="btnConsult">Consult</button><br>
            
          </div>
          <div class="adj2">
            <span id="loadingGiftCard"><img width="35px" src="img/ajax.gif"/></span>
            <label id="notFound">Sorry can not found your card, please try again</label>
          </div>
        </div>

        <div class="adj3">
            <label class="item" for="balanceAmount">Balance Amount</label>
            <input type="text" id="balanceAmount" class="inputMembership" readonly>
            <label class="item" for="points-BalanceAmount">Point Balance Amount</label>
            <input type="text" id="points-BalanceAmount" class="inputMembership" readonly>
        </div>

        <div class="adj4">
          <table>
            <tr>
              <td colspan="2">
                <button class="item" onclick="Editar()">Keep or change my cardnumber</button>
              </td>              
            </tr>
            <tr>
              <td>
                <button class="item" id="save" onclick="Save('<?php echo $id; ?>')">Save as my card number</button>
              </td>
              <td>
                <input class="item" id="TDM" type="text" placeholder="Num de tarjeta">
              </td>
            </tr>
            <tr>
              <td colspan="2"><button class="item" id="delete" onclick="">Delete card number</button></td>
            </tr>
            
          </table>
        </div>
        
      </div>
      
      <script>
        document.getElementById("save").style.display="none";
        document.getElementById("TDM").style.display="none";
        document.getElementById("delete").style.display="none";
        document.getElementById("notFound").style.display="none";

        let datos = {
          "id": <?php echo $id ?>
        } 

        fetch("Obj/BackGiftCard/consGC.php",
        {
          method:"POST",
          body:JSON.stringify(datos),
          headers: {"Content-type": "application/json;charset=UTF-8"}
        })
        .then(response=>response.json())
        .then(function(data)
        {
          if(data != 5678)
          {
            document.getElementById("cardnumber").value = data;
            document.getElementById('cardnumber').disabled = true;
            document.getElementById("btnConsult").style.display="none";
            document.getElementById("btnConsult").click();
            document.getElementById("loadingGiftCard").style.display="none";
          }else
          {
            document.getElementById("btnConsult").style.display="compact";
            document.getElementById("loadingGiftCard").style.display="none"; 
            saver = 0;
          }
        });

        //////////////////////////////////////////////////////////////////////////

        cardnumber.addEventListener("focus", function()
        {
          document.getElementById("loadingGiftCard").style.display="inline";
          document.getElementById("save").style.display="none";
          document.getElementById("TDM").style.display="none";
          document.getElementById("delete").style.display="none";
          document.getElementById("notFound").style.display="none"
        }
        );

        //////////////////////////////////////////////////////////////////////////
        
        btnConsult.addEventListener("click", function(){
           
          cardNumber=document.getElementById("cardnumber").value;
          
          let datos = {
            "CardN": cardNumber
          } 

          fetch("Obj/BackGiftCard/consultGiftCard.php",{
          method:"POST",
          body:JSON.stringify(datos),
          headers: {"Content-type": "application/json;charset=UTF-8"}
          })
          .then(response=>response.json())
          .then(function(data)
          {
            if(data.balanceAmount != null)
            {
              document.getElementById("balanceAmount").value=" "+data.balanceAmount;
              document.getElementById("points-BalanceAmount").value=" "+data.pointsBalanceAmount;
              document.getElementById("loadingGiftCard").style.display="none";
              document.getElementById("notFound").style.display="none";
            }else
            {
              document.getElementById("loadingGiftCard").style.display="none";
              document.getElementById("notFound").style.display="inline";
            }

          });
        });  

      </script>
    </div>

    <div id="profile" class="tabcontent">
      <table>
        <tr>
          <td class="ident">Company:</td>
          <td><?php echo $Com ?></td>
        </tr>
        <tr>
          <td class="ident">Full name:</td>
          <td style=""><?php echo $Desencriptar($Nam) ?></td>
        </tr>
        <tr>
          <td class="ident">Phone:</td>
          <td><?php echo $Tel ?></td>
        </tr>
        <tr>
          <td class="ident">Mail:</td>
          <td><?php echo $Ema ?></td>
        </tr>
        <tr>
          <td class="ident">Address:</td>
          <td><?php echo $Add ?></td>
        </tr>
        <tr>
          <td class="ident">City:</td>
          <td style=""><?php echo $Dir ?></td>
        </tr>
        <tr>
          <td class="ident">Z Code:</td>
          <td><?php echo $Cod ?></td>
        </tr>
      </table>
      <form action="Update.php" method="post">
        <span><button type="submit"><b>Update</b></Button></span>
      </form>
    </div>

    <div class="controles">
      <div class="icon">
        <button class="tablinks" onclick="opendiv(event, 'home')"><img src="img/Menu/home.png" alt="HOME" style="max-width: 37px; height: auto"></button>
        <br>HOME
      </div>
      <div class="icon">
        <button class="tablinks" onclick="opendiv(event, 'vehicles')"><img src="img/Menu/vehicle.jpg" style="max-width: 100%; height: 37px;"></button>
        <br>VEHICLES
      </div>
      <div class="icon">
        <button class="tablinks" onclick="opendiv(event, 'messages') "><img src="img/Menu/message.jpg" style="width: 37px; height: 37px"></button>
        <br>MEMBERSHIP REWARDS
      </div>
      <div class="icon">
        <button class="tablinks" onclick="opendiv(event, 'profile')"><img src="img/Menu/profile.png" style="width: 37px; height:37px"></button>
        <br>PROFILE
      </div>
    </div>

    <div class="back">
      <button class="sal" type="button" onclick="location.href='PagPrin.php'">LOGOUT</button>
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

  <script>
    function opendiv(evt, divName)
    {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++)
      {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++)
      {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(divName).style.display = "flex";
      evt.currentTarget.className += " active";
    }
  </script>


</body>
</html>
