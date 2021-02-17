<?php
require_once '../valid.php';

//SELECCIONA CURSOS CONFORME A DEPTO ACADEMICO
if (isset($_POST['deptoAcad']))
{
  $deptoAcad = $_POST['deptoAcad'];

  $qryCursos = $conn->query("SELECT idCurso, nombreCurso FROM curso c LEFT JOIN detalle_malla dm USING(idCurso) WHERE idDepartamento='$deptoAcad' AND c.estado=1 AND dm.AoL=1 AND dm.eliminado=0 GROUP BY idCurso ORDER BY nombreCurso") or die(mysqli_error($conn));

  echo "<option value=''>Seleccione una opción</option>";

  while($resQryCursos = $qryCursos->fetch_array()){
    echo "<option value='".$resQryCursos['idCurso']."'>". $resQryCursos['nombreCurso'] . "</option>";
  }
}


//SELECCIONA RUBRICA CONFORME A CURSO
if (isset($_POST['idCurso']))
{
  $idCurso = $_POST['idCurso'];

  $qryRubrica = $conn->query("SELECT * FROM rubrica WHERE estado=1 AND idCurso='$idCurso' GROUP BY idCurso, fechaAprobacion") or die(mysqli_error($conn));

    echo "<option value=''>Seleccione una opción</option>";

  while($resQryRubrica = $qryRubrica->fetch_array()){
    echo "<option value='".$resQryRubrica['fechaAprobacion']."'>". $resQryRubrica['fechaAprobacion'] . "</option>";
  }
}
