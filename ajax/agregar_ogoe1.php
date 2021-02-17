<?php
require_once '../valid.php';
$session_id= $_SESSION['session_id'];

if (isset($_POST['elegido2']))//codigo elimina un elemento del array
{
  $elegido2 = $_POST['elegido2'];
$qborrow2 = $conn->query("SELECT idObjgeneral,definicion FROM objgeneral where estado=1 and idObjgeneral='$elegido2'") or die(mysqli_error($conn));
while($fborrow2 = $qborrow2->fetch_array()){
							
    echo "<textarea required = 'required' id = 'definicion' name = 'definicion' class = 'form-control' rows='8' readonly = 'readonly'>".$fborrow2['definicion']."</textarea>";							
  }
    
}
