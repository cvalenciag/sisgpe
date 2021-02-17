<?php
	require_once '../valid.php';
	$session_id= $_SESSION['session_id'];

	$idCarrera 			= $_POST['idCarrera'];
	$fAprobacion 		= $_POST['fAprobacion'];
	$fActualizacion	= $_POST['fActualizacion'];
	$estado	 				= $_POST['estado'];

 	$sqlMalla =$conn->query("SELECT * FROM malla WHERE fAprobacion='".$fAprobacion."' AND idCarrera='".$idCarrera."' AND fActualizacion='".$fActualizacion."'AND fActualizacion='".$fActualizacion."' AND estado='".$estado."' AND eliminado=0");

	if($sqlMalla->num_rows > 0)
	{
		echo "<input type='hidden' id='idResult' value='1'/>";
	}
