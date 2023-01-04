<?php
include 'Conexion.php';

if (!empty($_POST["tipomar"])) 
{
  $query = "select IDmarca, descripcion from marca where type ='" .$_POST["tipomar"]. "'";
  $result = mysqli_query($conex, $query) or die (mysqli_error());

  echo '<option id="mark" value="">-- Select make --</option>';

  while ($row = mysqli_fetch_array($result))
  {
    echo '<option id="mark" value="'.$row['IDmarca'].'">'.$row['descripcion'].'</option>';
  }
}

if (!empty($_POST["IdMarca"]))
{
  $query = "select descripcion from modelo where Idmarca ='" .$_POST["IdMarca"]. "'";
  $result = mysqli_query($conex, $query);

  echo '<option id="mark" value="">-- Select model --</option>';

  while ($row = mysqli_fetch_array($result))
  {
    echo '<option value="' . $row['descripcion'] .' ">' . $row['descripcion'] . '</option>';
  }

}
?>
