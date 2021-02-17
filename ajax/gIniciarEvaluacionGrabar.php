<?php

require_once 'valid.php';

$option       = $_REQUEST['option'];

if($option == 'upEscrito')
{
  $idCriterio   = $_REQUEST['idCriterio'];
  $idRubrica    = $_REQUEST['idRubrica'];
  $puntaje      = $_REQUEST['puntaje'];
  $idEvaluador  = $_REQUEST['idEvaluador'];
  $idEvaluacion = $_REQUEST['idEvaluacion'];


  $qrySubCriterios = $conn->query("SELECT * FROM subcriterio WHERE idCriterio='$idCriterio'") or die(mysqli_error($conn));

  foreach ($qrySubCriterios as $subCri)
  {
    $valMinimo = $subCri['minimo'];
    $valMaximo = $subCri['maximo'];

    if($puntaje>=$valMinimo && $puntaje<=$valMaximo)
    {
      $idNivel = $subCri['idNivel'];

      $conn->query("UPDATE detalle_evaluacion SET puntajeEvaluador='$puntaje', idNivel='$idNivel' WHERE idEvaluacion='$idEvaluacion' AND idRubrica='$idRubrica' AND idCriterio='$idCriterio' AND idEvaluador='$idEvaluador'") or die(mysqli_error($conn));

      echo json_encode(1);

    }
  }

  // $qryPesoRubrica = $conn->query("SELECT * FROM rubrica WHERE idRubrica='$idRubrica'") or die(mysqli_error($conn));
  // $resPesoRubrica = $qryPesoRubrica->fetch_array();
  // $pesoRubrica    = $resPesoRubrica['peso'];
  //
  // $puntajePeso = (($pesoRubrica/100) * $puntaje);

  // $qryPuntaje = $conn->query("SELECT * FROM detalle_rubrica WHERE idRubrica='$idRubrica' AND puntajeRango='$puntaje'")
  // or die(mysqli_error($conn));
  // $resPuntaje = $qryPuntaje->fetch_array();
  //
  // if($qryPuntaje->num_rows==1)
  // {
  //
  //   $nivel = $resPuntaje['idNivel'];
  //
  //   $conn->query("UPDATE detalle_evaluacion SET puntajeEvaluador='$puntaje', idNivel='$nivel', puntajePeso='$puntajePeso' WHERE idEvaluacion='$idEvaluacion' AND idRubrica='$idRubrica' AND idAlumno='$idAlumno' AND idEvaluador='$idEvaluador'") or die(mysqli_error($conn));
  //
  //   $qryPuntaje = $conn->query("SELECT SUM(puntajeEvaluador) as totalPuntaje  FROM detalle_evaluacion de
  //   LEFT JOIN alumno a ON (a.idAlumno = de.idAlumno) WHERE idEvaluacion='$idEvaluacion'
  //   AND de.idAlumno='$idAlumno' AND idEvaluador='$idEvaluador'") or die(mysqli_error($conn));
  //   $resPuntaje = $qryPuntaje->fetch_assoc();
  //   $sumPuntaje = $resPuntaje['totalPuntaje'];
  //
  //   $data = array('estado' => '1', 'idAlumno' => $idAlumno, 'totalPuntaje' => $sumPuntaje);
  //
  //   echo json_encode($data, JSON_FORCE_OBJECT);
  //
  // }else {
  //
  //   $qryPuntaje = $conn->query("SELECT SUM(puntajeEvaluador) as totalPuntaje  FROM detalle_evaluacion de
  //   LEFT JOIN alumno a ON (a.idAlumno = de.idAlumno) WHERE idEvaluacion='$idEvaluacion'
  //   AND de.idAlumno='$idAlumno' AND idEvaluador='$idEvaluador'") or die(mysqli_error($conn));
  //   $resPuntaje = $qryPuntaje->fetch_assoc();
  //   $sumPuntaje = $resPuntaje['totalPuntaje'];
  //
  //   $data = array('estado' => '0', 'idAlumno' => $idAlumno, 'totalPuntaje' => $sumPuntaje);
  //
  //   echo json_encode($data);
  // }
}

// PARA EVALUACION ORAL ======================================================================
if($option == 'upOral')
{
  $idAlumno     = $_REQUEST['idAlumno'];
  $idCriterio   = $_REQUEST['idCriterio'];
  $idRubrica    = $_REQUEST['idRubrica'];
  $puntaje      = $_REQUEST['puntaje'];
  $idEvaluador  = $_REQUEST['idEvaluador'];
  $idEvaluacion = $_REQUEST['idEvaluacion'];

  $qrySubCriterios = $conn->query("SELECT * FROM subcriterio WHERE idCriterio='$idCriterio' AND total='$puntaje'") or die(mysqli_error($conn));
  $resSubCriterios = $qrySubCriterios->fetch_array();

  if($qrySubCriterios->num_rows==1)
  {
    $idNivel = $resSubCriterios['idNivel'];

    $conn->query("UPDATE detalle_evaluacion SET puntajeEvaluador='$puntaje', idNivel='$idNivel' WHERE idEvaluacion='$idEvaluacion' AND idRubrica='$idRubrica' AND idAlumno='$idAlumno' AND idEvaluador='$idEvaluador'") or die(mysqli_error($conn));

    echo json_encode(1);
  }
}


// ACTUALIZA OBSERVACIONES ====================================================================
if($option == 'upObs')
{
  $idRubrica    = $_REQUEST['idRubrica'];
  $idCriterio   = $_REQUEST['idCriterio'];
  $observacion  = $_REQUEST['observa'];
  $idEvaluador  = $_REQUEST['idEvaluador'];
  $idEvaluacion = $_REQUEST['idEvaluacion'];

  $conn->query("UPDATE detalle_evaluacion SET observacion='$observacion' WHERE idEvaluacion='$idEvaluacion' AND idRubrica='$idRubrica' AND idCriterio='$idCriterio' AND idEvaluador='$idEvaluador'") or die(mysqli_error($conn));

  echo json_encode(1);
}




// ACTUALIZA COMENTARIOS ====================================================================
if($option == 'upComs')
{
  $idEvaluador  = $_REQUEST['idEvaluador'];
  $idEvaluacion = $_REQUEST['idEvaluacion'];
  $comentario   = $_REQUEST['comentario'];

  $conn->query("UPDATE detalle_evaluacion SET comentario='$comentario' WHERE idEvaluacion='$idEvaluacion' AND idEvaluador='$idEvaluador'") or die(mysqli_error($conn));

  echo json_encode(1);
}


if($option == 'ee'){
  $idEvaluador  = $_REQUEST['idEvaluador'];
  $idEvaluacion = $_REQUEST['idEvaluacion'];

  $qryDatosEval = $conn->query("SELECT * FROM detalle_evaluacion WHERE idEvaluacion='$idEvaluacion' AND idEvaluador='$idEvaluador'AND idNivel=0") or die(mysqli_error($conn));

  if($qryDatosEval->num_rows>0){
      $conn->query("UPDATE evaluacion SET estadoEval=1 WHERE idEvaluacion='$idEvaluacion'") or die(mysqli_error($conn));
  }else {
      $conn->query("UPDATE evaluacion SET estadoEval=2 WHERE idEvaluacion='$idEvaluacion'") or die(mysqli_error($conn));
  }

}
