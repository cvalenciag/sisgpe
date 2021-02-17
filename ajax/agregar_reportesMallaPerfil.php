<?php
require_once '../valid.php';

// MUESTRA LAS FECHAS DE MALLA ===================================================================================
if (isset($_POST['elegido']))
{
  $elegido = $_POST['elegido'];

  $qborrow = $conn->query("SELECT * FROM carrera WHERE estado=1 AND idFacultad='$elegido'") or die(mysqli_error($conn));

		echo '<option value="" selected="selected">Seleccione una opción</option>';

  while($fborrow = $qborrow->fetch_array()){
    echo "<option value='".$fborrow['idCarrera']."'>". $fborrow['descripcion'] . "</option>";
  }
}


if (isset($_POST['elegido2']))
{
  $elegido2 = $_POST['elegido2'];

  $qborrow2 = $conn->query("SELECT * FROM malla WHERE eliminado=0 AND idCarrera='$elegido2'") or die(mysqli_error($conn));

  while($fborrow2 = $qborrow2->fetch_array()){
    echo "<option value='".$fborrow2['fAprobacion']."'>". $fborrow2['fAprobacion'] . "</option>";
  }
}


// SEGUNDO REPORTE ======================================================================================================

if (isset($_POST['elegidop1']))
{
  $elegidop1 = $_POST['elegidop1'];

  $qborrowp = $conn->query("SELECT * FROM carrera WHERE estado=1 AND idFacultad='$elegidop1'") or die(mysqli_error($conn));

		echo '<option value="" selected="selected">Seleccione una opción</option>';

  while($fborrowp = $qborrowp->fetch_array()){
    echo "<option value='".$fborrowp['idCarrera']."'>". $fborrowp['descripcion'] . "</option>";
  }
}


if (isset($_POST['elegidop2']))
{
	$elegidop2		= $_POST['elegidop2'];

	$qborrowp2 = $conn->query("SELECT cc.fAprobacion FROM carrera_competencia cc INNER JOIN carrera_og cog USING (idCarrera, fAprobacion, eliminado) WHERE cc.idCarrera='$elegidop2'") or die(mysqli_error($conn));

	while($fborrowp2 = $qborrowp2->fetch_array()){
		echo "<option value='".$fborrowp2['fAprobacion']."'>".$fborrowp2['fAprobacion']."</option>";
	}
}
