<?php
include 'Conexion.php';
$query = "select IDmarca, descripcion from marca where type ='" .$_POST["tipomar"]. "'";
$result = mysqli_query($conex, $query) or die (mysqli_error());
if (!empty($_POST["tipomar"])) {
  while ($row = mysqli_fetch_array($result)){
    echo '<option id="mark" value="'.$row['IDmarca'].'">'.$row['descripcion'].'</option>';
  }
}
?>
