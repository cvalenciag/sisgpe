<?php

require_once '../valid.php';
$session_id= $_SESSION['session_id'];

$idCarrera 		= $_REQUEST['idCarrera'];
$fAprobacion	= $_REQUEST['fAprobacion'];

// echo $idCarrera.'_'.$fAprobacion;
// 				$fActualizacion = $_POST['fActualizacion'];
//
// $estado = $_POST['estado'];

$sqlDetalles = $conn->query("SELECT * FROM tmp WHERE idCarrera='".$idCarrera."' AND fAprobacion='".$fAprobacion."'");
if ($sqlDetalles->num_rows == 0){
		$vacio = 1;
		echo $vacio;
 }else {
 	$vacio = 0;
 }


?>
