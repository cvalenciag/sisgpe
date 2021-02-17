<?php
require_once '../valid.php';

// MUESTRA LAS FECHAS DE MALLA ===================================================================================
if (isset($_POST['elegido']))
{
  $elegido = $_POST['elegido'];

  $qborrow = $conn->query("SELECT * FROM malla WHERE eliminado=0 AND idCarrera='$elegido'") or die(mysqli_error($conn));

  while($fborrow = $qborrow->fetch_array()){
    echo "<option value='".$fborrow['fAprobacion']."'>". $fborrow['fAprobacion'] . "</option>";
  }
}


if (isset($_POST['elegido2']))
{
  $elegido2 = $_POST['elegido2'];
  $elegido3 = $_POST['elegido3'];

  if($elegido2!=3){
    $qborrow2 = $conn->query("SELECT * FROM detalle_carrera_competencia LEFT JOIN competencia c USING (idCompetencia) WHERE idCarrera='$elegido3' AND idTipo='$elegido2'") or die(mysqli_error($conn));
  }else {
    $qborrow2 = $conn->query("SELECT * FROM detalle_carrera_competencia LEFT JOIN competencia c USING (idCompetencia) WHERE idCarrera='$elegido3'") or die(mysqli_error($conn));
  }


  if($elegido2!=3){

    echo "<option value='0'>Todos</option>";

    while($fborrow2 = $qborrow2->fetch_array()){
      echo "<option value='".$fborrow2['idCompetencia']."'>". $fborrow2['descripcion'] . "</option>";
    }
  }else {
    echo "<option value='0'>Todos</option>";
  }

}
