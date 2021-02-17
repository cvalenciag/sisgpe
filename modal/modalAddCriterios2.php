<?php
require_once '../valid.php';
$session_id	= $_SESSION['session_id'];
 

// FILTRO PARA FECHAS DE FACULTAD ==================================================================================================
// if (isset($_POST['idTipoComp']))
if (isset($_POST['tipo']) == 't')
{
		$idCriterio	= $_POST['idCriterio'];
		$idTipoComp	= $_POST['idTipoComp'];
		$qryComp   	= $conn->query("SELECT * FROM competencia WHERE estado=1 AND idTipo='$idTipoComp'") or die(mysqli_error($conn));

		$dataCompetencias = array();

		while($row = $qryComp->fetch_assoc()){
			$dataCompetencias[] = $row;
		}

		$data = array('idCriterio' => $idCriterio, 'competencias' => $dataCompetencias);

		echo json_encode($data, JSON_FORCE_OBJECT);
}


// if (isset($_POST['idCompetencia']))
if (isset($_POST['idCompetencia']) == 'cc')
{
		$idCriterio	= $_POST['idCriterio'];
		$idComp	  	= $_POST['idCompetencia'];
		$qryObj  		= $conn->query("SELECT * FROM objgeneral WHERE estado=1 AND idCompetencia='$idComp'") or die(mysqli_error($conn));

		$dataObjetivos = array();

		while($row = $qryObj->fetch_assoc()){
			$dataObjetivos[] = $row;
		}

		$data = array('idCriterio' => $idCriterio, 'objetivos' => $dataObjetivos);

		echo json_encode($data, JSON_FORCE_OBJECT);
}
