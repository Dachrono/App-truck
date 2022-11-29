<?php
	//Ver 2.0 Rev 29/09

	if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    include 'Obj/Encryp.php';
    session_start();

    $_SESSION['User'] = ($_POST['user']);
    $_SESSION['Pass'] = $Encriptar($_POST['pass']);

    echo '<script>window.location.href = "Obj/Login.php";</script>';
	}
?>

<html>
  <head>

    <title>TruckSavers</title>

    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/PagPrin.css" rel="stylesheet" type="text/css">

  </head>

  <body>

    <div class="Contenedor1">

      <div class="logo">

        <img name="Ts" src="img/LogoPrin.png" width="450px">

      </div>

      <div class="login">

        <form action="" method="post">

          <input type="text" name="user" placeholder="User" required/>
          <input type="password" name="pass" placeholder="Password" required/>
          <p>
          <!--<a href="#">Forgot passwoord?</a>
          <input type="radio" name="remember" value="Yes">Remember me</input>
				</p>-->
          <button type="submit";>Login</button>

        </form>

        <form action="NuevoUsuario.php">
            <button type="submit";>Create new user</button>
        </form>

				<!--<form action="mails/Send.php">
            <button type="submit";>mandar</button>
        </form>-->

      </div>

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

  </body>
</html>
