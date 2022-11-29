<?php

function BodyClienteNuevo($fullname, $usuario, $pass)
{
  return $body ="
    <html lang='es'>
    <head>
      <meta charset='UTF-8'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <link rel='preconnect' href='https://fonts.googleapis.com'>
      <title>Mensaje</title>
      <style>
        *{ margin: 0px; padding: 0; box-sizing: border-box; font-family: 'Raleway', sans-serif; }

        body{ margin: 10px; }

        h1{ padding-top: 20px; text-align: center; width: 70%; }

        .encabezado{ width: 100%; height: 100px; display: flex; background: #7AD66C; border-radius: 5px; }

        .encabezado a{ font-size: 20px; color: green; font-weight: 600; padding-top: 20px; text-align: center; -webkit-text-stroke: 1px black; }

        img#logo{ width: 130px; height: 100px; }

        .cuerpo{ width: 80%; margin: 0 auto; margin-top: 30px; height: 250px; }

        .datos{ font-weight: bold; }

        a{ text-decoration: none; }

        .contenedor2{ font-size: 15px; font-style: oblique; font-weight: bold; text-align: center; margin: 0 auto; margin-top: 20px; width: 100%; background-color: rgba(235, 179, 40, 0.80); }

        .contenedor2 a{ color: black; margin: 8px 10px 5px 0; }

        .contenedor2 div{ height: 40px; }

        .contenedor3 { font-size: 12px; color: #ffffff; text-align: center; background-color: #000000; width: 100%; }

        .contenedor3 a{ display:block; padding: 5px 0 2px 2px; color: #ffffff; }

        @media (max-width: 485px)
        {
          img#logo{ width: 80px; height: 60px; } h1{ font-size: 20px; }
        }

        @media (min-width: 800px)
        {
          .cuerpo{ width: 800px; margin: 0 auto; margin-top: 40px;}
          .cuerpo>p{padding-left: 20%;}
          body{max-width: 800px; margin: 10px auto;}
        }
      </style>
    </head>
    <body>
        <header class='encabezado'>
          <h1>Welcome $fullname.</h1>
          <a href='#'>TRUCK SAVERS</a>
        </header>

        <section class='cuerpo'>
          <p>
            You have successfully registered to The Truck Savers app.<br><br><br><br>
          <p>
            Your Login details are<br><br>
            User: $usuario<span class='datos'></span><br>
            Password: $pass<span class='datos'></span>
          </p>
        </section>

        <div class='contenedor2'>

        Remember to follow us on our social networks...
        <br>
        <br>

        <div>
          <a href='https://www.facebook.com/TheTruckSavers/' target='_blank'>Facebook</a>
          <a href='https://www.tiktok.com/@thetrucksavers?' target='_blank'>Tik Tok</a>
          <a href='https://www.instagram.com/thetrucksavers/' target='_blank'>Instagram</a>
          <a href='https://www.youtube.com/channel/UCNt6mtWisgfxaLwxjp2GGrg' target='_blank'>YouTube</a>
          <a href='https://t.me/thetrucksavers' target='_blank'>Telegram</a>
        </div>

        </div>

        <div class='contenedor3'>

          <a href='https://goo.gl/maps/XwdBePetmBCNaouT6'>1362 Sheffield Blvd, Houston, TX, United States</a>
          <a>Telefono: 713-455-5566</a>
          <a>All rights reserved. The Truck Savers 2022</a>

        </div>
    </body>
    </html>";
}

function BodyCita($name, $servicio, $unidad, $fecha, $hora)
{
  return $body ="
  <html lang='es'>
  <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <title>Mensaje</title>
    <style>
      *{ margin: 0px; padding: 0; box-sizing: border-box; font-family: 'Raleway', sans-serif; }

      body{ margin: 10px; }

      h1{ padding-top: 20px; text-align: center; width: 70%; }

      .encabezado{ width: 100%; height: 100px; display: flex; background: #7AD66C; border-radius: 5px; }

      .encabezado a{ font-size: 20px; color: green; font-weight: 600; padding-top: 20px; text-align: center; -webkit-text-stroke: 1px black; }

      img#logo{ width: 130px; height: 100px; }

      .cuerpo{ width: 80%; margin: 0 auto; margin-top: 30px; height: 250px; }

      .datos{ font-weight: bold; }

      a{ text-decoration: none; }

      .contenedor2{ font-size: 15px; font-style: oblique; font-weight: bold; text-align: center; margin: 0 auto; margin-top: 20px; width: 100%; background-color: rgba(235, 179, 40, 0.80); }

      .contenedor2 a{ color: black; margin: 8px 10px 5px 0; }

      .contenedor2 div{ height: 40px; }

      .contenedor3 { font-size: 12px; color: #ffffff; text-align: center; background-color: #000000; width: 100%; }

      .contenedor3 a{ display:block; padding: 5px 0 2px 2px; color: #ffffff; }

      @media (max-width: 485px)
      {
        img#logo{ width: 80px; height: 60px; } h1{ font-size: 20px; }
      }

      @media (min-width: 800px)
      {
        .cuerpo{ width: 800px; margin: 0 auto; margin-top: 40px;}
        .cuerpo>p{ padding-left: 20%;}
        body{ max-width: 800px; margin: 10px auto;}
      }

    </style>
    </head>

    <body>

      <header class='encabezado'>
        <h1>Successful registration.</h1>
        <a href='#'>TRUCK SAVERS</a>
      </header>

      <section class='cuerpo'>
        <p>
          Hi! $name<br><br>
          You have registered a visit to $servicio for your unit $unidad <br><br>

          On $fecha at $hora <br>
          We are waiting for you...
        </p>
      </section>

      <div class='contenedor2'>

      Remember to follow us on our social networks...
      <br>
      <br>

      <div>
        <a href='https://www.facebook.com/TheTruckSavers/' target='_blank'>Facebook</a>
        <a href='https://www.tiktok.com/@thetrucksavers?' target='_blank'>Tik Tok</a>
        <a href='https://www.instagram.com/thetrucksavers/' target='_blank'>Instagram</a>
        <a href='https://www.youtube.com/channel/UCNt6mtWisgfxaLwxjp2GGrg' target='_blank'>YouTube</a>
        <a href='https://t.me/thetrucksavers' target='_blank'>Telegram</a>
      </div>

      </div>

      <div class='contenedor3'>

        <a href='https://goo.gl/maps/XwdBePetmBCNaouT6'>1362 Sheffield Blvd, Houston, TX, United States</a>
        <a>Telefono: 713-455-5566</a>
        <a>All rights reserved. The Truck Savers 2022</a>

      </div>

    </body>
  </html>";
}

function BodyTaller($name, $fecha, $hora, $servicio, $unidad, $millas, $aceite, $null, $mensaje, $f_aire, $GreaseS, $aditivo, $notas)
{
  return $body ="
  <html lang='es'>
  <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <title>Mensaje</title>
    <style>
      *{ margin: 0px; padding: 0; box-sizing: border-box; font-family: 'Raleway', sans-serif; }

      body{ margin: 10px; }

      h1{ padding-top: 20px; text-align: center; width: 70%; }

      .encabezado{ width: 100%; height: 100px; display: flex; background: #7AD66C; border-radius: 5px; }

      .encabezado a{ font-size: 20px; color: green; font-weight: 600; padding-top: 20px; text-align: center; -webkit-text-stroke: 1px black; }

      img#logo{ width: 130px; height: 100px; }

      .cuerpo{ width: 80%; margin: 0 auto; margin-top: 30px; height: 350px; }

      .datos{ font-weight: bold; }

      a{ text-decoration: none; }

      .contenedor2{ font-size: 15px; font-style: oblique; font-weight: bold; text-align: center; margin: 0 auto; margin-top: 20px; width: 100%; background-color: rgba(235, 179, 40, 0.80); }

      .contenedor2 a{ color: black; margin: 8px 10px 5px 0; }

      .contenedor2 div{ height: 40px; }

      .contenedor3 { font-size: 12px; color: #ffffff; text-align: center; background-color: #000000; width: 100%; }

      .contenedor3 a{ display:block; padding: 5px 0 2px 2px; color: #ffffff; }

      @media (max-width: 485px)
      {
        img#logo{ width: 80px; height: 60px; } h1{ font-size: 20px; }
      }

      @media (min-width: 800px)
      {
        .cuerpo{ width: 800px; margin: 0 auto; margin-top: 40px;}
        .cuerpo>p{ padding-left: 20%;}
        body{ max-width: 800px; margin: 10px auto;}
      }

    </style>
    </head>

    <body>
      <header class='encabezado'>
        <h1>New appointment</h1>
        <a href='#'>TRUCK SAVERS</a>
      </header>

      <section class='cuerpo'>
        <p>
          The client $name registered an appointment for today $fecha at $hora <br><br>
          Required service: $servicio <br>
          Unit: $unidad with mileage: $millas <br><br>

          The preferred oil is: $aceite <br><br>

          $null<br> $mensaje<br> $f_aire<br> $GreaseS<br> $aditivo<br> $notas
        </p>
      </section>

      <div class='contenedor2'>

      Remember to follow us on our social networks...
      <br>
      <br>

      <div>
        <a href='https://www.facebook.com/TheTruckSavers/' target='_blank'>Facebook</a>
        <a href='https://www.tiktok.com/@thetrucksavers?' target='_blank'>Tik Tok</a>
        <a href='https://www.instagram.com/thetrucksavers/' target='_blank'>Instagram</a>
        <a href='https://www.youtube.com/channel/UCNt6mtWisgfxaLwxjp2GGrg' target='_blank'>YouTube</a>
        <a href='https://t.me/thetrucksavers' target='_blank'>Telegram</a>
      </div>

      </div>

      <div class='contenedor3'>

        <a href='https://goo.gl/maps/XwdBePetmBCNaouT6'>1362 Sheffield Blvd, Houston, TX, United States</a>
        <a>Telefono: 713-455-5566</a>
        <a>All rights reserved. The Truck Savers 2022</a>

      </div>

    </body>
  </html>";
}

?>
