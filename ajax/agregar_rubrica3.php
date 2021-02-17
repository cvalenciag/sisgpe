<?php
require_once '../valid.php';
$session_id= $_SESSION['session_id'];

if (isset($_POST['elegido2']))//codigo elimina un elemento del array
{
  $elegido2 = $_POST['elegido2'];
  $qborrow2 = $conn->query("SELECT idObjgeneral, definicion FROM objgeneral where estado=1 and idObjgeneral='$elegido2'") or die(mysqli_error($conn));

  while($fborrow2 = $qborrow2->fetch_array()){
    echo "<textarea required = 'required' id ='definicion' name = 'definicion' class = 'form-control' style='height:100px;' rows='8' readonly = 'readonly'>".$fborrow2['definicion']."</textarea>";
  }

}
 

if (isset($_POST['elegidoC']))//codigo elimina un elemento del array
{
  $elegidoC = $_POST['elegidoC'];
  $qborrowC = $conn->query("SELECT idCriterio, definicion FROM criterio where estado=1 and idCriterio='$elegidoC'") or die(mysqli_error($conn));

  while($fborrowC = $qborrowC->fetch_array()){

  echo "<textarea required = 'required' id ='definicion' name = 'definicion' style='height:100px;' class = 'form-control' rows='8' readonly = 'readonly'>".$fborrowC['definicion']."</textarea>";
  }

}


?>
