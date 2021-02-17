<?php
require_once '../valid.php';

// MUESTRA LAS CARRERAS ===================================================================================
if (isset($_POST['elegido']))
{
  $elegido = $_POST['elegido'];

  $qborrow = $conn->query("SELECT * FROM carrera WHERE estado=1 AND idFacultad='$elegido'") or die(mysqli_error($conn));

		echo '<option value="" selected="selected">Seleccione una opción</option>';

  while($fborrow = $qborrow->fetch_array()){
    echo "<option value='".$fborrow['idCarrera']."'>". $fborrow['descripcion'] . "</option>";
  }
}


// MUESTRA LAS FECHAD MALLA ===================================================================================
if (isset($_POST['elegido2']))
{
  $idCarrera	= $_POST['elegido2'];
  $qborrowC		= $conn->query("SELECT * FROM malla WHERE idCarrera='$idCarrera' AND eliminado=0") or die(mysqli_error($conn));

  echo "<option value='' selected='selected'>Seleccione una opción</option>";

	while($fborrowC = $qborrowC->fetch_array()){
    echo "<option value='".$fborrowC['fAprobacion']."'>".$fborrowC['fAprobacion']."</option>";
  }
}


 
if (isset($_POST['elegido3']))
{
	// $fechaMalla	= $_POST['fechaMalla'];
	$Carrera		= $_POST['elegido3'];

	$qborrowFM = $conn->query("SELECT cc.fAprobacion FROM carrera_competencia cc INNER JOIN carrera_og cog USING (idCarrera, fAprobacion, eliminado) WHERE cc.idCarrera='$Carrera'") or die(mysqli_error($conn));

	echo "<option value='' selected='selected'>Seleccione una opción</option>";

	while($fborrowFM = $qborrowFM->fetch_array()){
		echo "<option value='".$fborrowFM['fAprobacion']."'>".$fborrowFM['fAprobacion']."</option>";
	}
}
