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
  $qborrowC		= $conn->query("SELECT idMalla, idCarrera, fAprobacion FROM malla WHERE idCarrera='$idCarrera' AND eliminado=0") or die(mysqli_error($conn));

  echo "<option value='' selected='selected'>Seleccione una opción</option>";

	while($fborrowC = $qborrowC->fetch_array()){
    echo "<option value='".$fborrowC['fAprobacion']."'>".$fborrowC['fAprobacion']."</option>";
  }
}

// FILTRO PARA FECHAS DE PERFIL ===============================================================================================

if (isset($_POST['fechaMalla']))
{
	$fechaMalla	= $_POST['fechaMalla'];

	$qborrowFM = $conn->query("SELECT cc.fAprobacion from carrera_competencia cc INNER JOIN carrera_og cog ON cc.fAprobacion=cog.fAprobacion INNER JOIN og_oe oge ON cog.fAprobacion=oge.fAprobacion WHERE cc.fAprobacion='$fechaMalla' GROUP BY cc.idCarrera") or die(mysqli_error($conn));

	// echo "<option value='' selected='selected'>Seleccione una opción</option>";

	while($fborrowFM = $qborrowFM->fetch_array()){
		echo "<option value='".$fborrowFM['fAprobacion']."'>".$fborrowFM['fAprobacion']."</option>";
	}
}
