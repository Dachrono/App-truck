<?php

  if(!empty($_POST["usuario"]))
  {
    include 'Conexion.php';

      $query = "select * from usuarios where '" .$_POST["usuario"]. "' = usuario";
      $result = mysqli_query($conex, $query);
      $row = mysqli_fetch_array($result);

      if(!isset($row))
      {
        echo 1234;
      }
      else
      {
        echo 5678;
      }
    }

?>
