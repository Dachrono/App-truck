<?php

include '../Conexion.php';

$datos= json_decode(file_get_contents("php://input"));
$id=$datos->id;

$query = "select * from cliente_tdm where '$id' = idcliente";
$result = mysqli_query($conex, $query);
$row = mysqli_fetch_array($result);

if(!empty($row))
{
    if($row['NumTar'] != null)
    {
        echo json_encode($row['NumTar']);
    }else
    {
        echo 5678;
    }
}
else
{
    echo 5678;
}
?>