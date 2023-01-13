<?php

include "Conexion.php";

$fun = $_POST['fun'];

if($fun === "a")
{   
    $id = $_POST['name'];
    $num = $_POST['tar'];

    $query = "select * from cliente_tdm where $id = idcliente";
    $result = mysqli_query($conex, $query);
    $row = mysqli_fetch_array($result);

    if(!empty($row))
    {
        $query = $conex -> prepare ("update cliente_tdm set NumTar= $num where $id = idcliente");
        $query -> execute();
    }else
    {
        $query = $conex -> prepare ("insert into cliente_tdm (idcliente, NumTar) values (?,?)");
        $query -> bind_param("ss", $id, $num); 
        $query -> execute();
    }
}

if ($fun === "b")
{
    $id = $_POST['name'];
    
    $query = $conex -> prepare ("update cliente_tdm set NumTar= null where $id = idcliente");
    $query -> execute();
}
?>