<?php

 if(!empty($_POST["mail"]))
 {
    include "Conexion.php";
    
    $query="select mail from cliente where mail = '" .$_POST["mail"]. "'";
    $resultado = mysqli_query($conex, $query);
    $row = mysqli_fetch_array($resultado);

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