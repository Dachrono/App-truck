<?php

include 'Conexion.php';
session_start();

$user = $_SESSION['User'];

$query = "select * from usuarios where '$user' = usuario";
$result = mysqli_query($conex, $query);
$row = mysqli_fetch_array($result);

if(isset($row))
{
  $BD_User = $row["usuario"];
  $BD_Pass = $row["contrasena"];
  $DB_Id = $row["idcliente"];

  if($_SESSION['User'] == $BD_User)
  {
    if($_SESSION['Pass'] == $BD_Pass)
    {
      $query = "select * from cliente where '$DB_Id' = IDcliente";
      $result = mysqli_query($conex, $query);
      $row = mysqli_fetch_array($result);

      $_SESSION['Nombre'] = $row["full_name"];
      $_SESSION['Id'] = $row["IDcliente"];

      unset($_SESSION['User']);
      unset($_SESSION['Pass']);

      echo '<script>window.location.href = "../Main.php";</script>';
    }
    else
    {
      echo '<script language="javascript">alert("Contraseña incorrecta");window.location.href="../PagPrin.php"</script>';
    }
  }
  else
  {
    echo '<script language="javascript">alert("Usuario incorrecto");window.location.href="../PagPrin.php"</script>';;
  }
}
else
{
  echo '<script language="javascript">alert("Usuario inexistente");window.location.href="../PagPrin.php"</script>';
}

?>
