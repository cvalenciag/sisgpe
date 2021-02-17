<?php
require_once 'valid.php';

$idcarrera    = (isset($_REQUEST['idcarrera']) && !empty($_REQUEST['idcarrera']))?$_REQUEST['idcarrera']:'';
$idcurso      = (isset($_REQUEST['idcurso']) && !empty($_REQUEST['idcurso']))?$_REQUEST['idcurso']:'';
$newRegistro  = (isset($_REQUEST['nuevoRegistro']) && !empty($_REQUEST['nuevoRegistro']))?$_REQUEST['nuevoRegistro']:'';

if ($newRegistro == 'NR')
{
	$qryExistenRegistros = $conn->query("SELECT * FROM detalle_curso_nivelaporte WHERE idCarrera='$idcarrera' AND idCurso='$idcurso'");

	if($qryExistenRegistros->num_rows > 0){
		$deleteNivel = mysqli_query($conn, "DELETE FROM detalle_curso_nivelaporte WHERE idCarrera='$idcarrera' AND idCurso='$idcurso'");
	}

}
