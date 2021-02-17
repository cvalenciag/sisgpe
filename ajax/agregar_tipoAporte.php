<?php
require_once '../valid.php';
$session_id= $_SESSION['session_id'];


// FILTRO PARA FECHAS DE FACULTAD ==================================================================================================
if (isset($_POST['idFacultad']))
{
		$idFacultad	= $_POST['idFacultad'];
		$qborrow    = $conn->query("SELECT idCarrera, descripcion FROM carrera WHERE estado=1 AND idFacultad='$idFacultad'") or die(mysqli_error($conn));

		echo "<option value='' selected='selected'>Seleccione una opción</option>";

		while($fborrow = $qborrow->fetch_array()){
      echo "<option value='".$fborrow['idCarrera']."'>".$fborrow['descripcion']."</option>";
    }
}

// FILTRO PARA FECHAS DE PERFIL
if (isset($_POST['idCarrera']))
{
  $idCarrera	= $_POST['idCarrera'];
  $qborrowC		= $conn->query("SELECT * FROM malla WHERE idCarrera='$idCarrera' AND eliminado=0") or die(mysqli_error($conn));

  echo "<option value='' selected='selected'>Seleccione una opción</option>";

	while($fborrowC = $qborrowC->fetch_array()){
    echo "<option value='".$fborrowC['fAprobacion']."'>".$fborrowC['fAprobacion']."</option>";
  }
}

// FILTRO PARA FECHAS DE PERFIL ===============================================================================================

if (isset($_POST['idCarrera2']))
{
	// $fechaMalla	= $_POST['fechaMalla'];
	$Carrera		= $_POST['idCarrera2'];

	$qborrowFM = $conn->query("SELECT cc.fAprobacion FROM carrera_competencia cc INNER JOIN carrera_og cog USING (idCarrera, fAprobacion, eliminado) WHERE cc.idCarrera='$Carrera'") or die(mysqli_error($conn));

	// echo "<option value='' selected='selected'>Seleccione una opción</option>";

	while($fborrowFM = $qborrowFM->fetch_array()){
		echo "<option value='".$fborrowFM['fAprobacion']."'>".$fborrowFM['fAprobacion']."</option>";
	}
}
 
