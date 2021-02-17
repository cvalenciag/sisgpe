<?php
require_once 'connect.php';
$session_id   = $_SESSION['session_id'];

 
  $estado	  = (isset($_REQUEST['estado']) && !empty($_REQUEST['estado']))?$_REQUEST['estado']:'';
  $admin_id = (isset($_REQUEST['admin_id']) && !empty($_REQUEST['admin_id']))?$_REQUEST['admin_id']:'';

  $conn->query("UPDATE rubrica SET estado='$estado' WHERE idRubrica='$admin_id'") or die(mysqli_error($conn));

  if ($conn->affected_rows==1){
  	$conn->query("UPDATE detalle_rubrica SET eliminado='$estado' WHERE idRubrica='$admin_id'") or die(mysqli_error($conn));
  }

  echo '<script type = "text/javascript">
  				window.location = "rubricas.php";
  			</script>';
