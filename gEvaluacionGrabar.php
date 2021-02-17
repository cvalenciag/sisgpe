<?php

require_once 'valid.php';
$session_id = $_SESSION['session_id'];

$cabecera = (isset($_REQUEST['cabecera']) && !empty($_REQUEST['cabecera']))?$_REQUEST['cabecera']:'';
$tempEval = (isset($_REQUEST['tempEval']) && !empty($_REQUEST['tempEval']))?$_REQUEST['tempEval']:'';

$editaEval  = (isset($_REQUEST['editaEval']) && !empty($_REQUEST['editaEval']))?$_REQUEST['editaEval']:'';
$updateEval = (isset($_REQUEST['updateEval']) && !empty($_REQUEST['updateEval']))?$_REQUEST['updateEval']:'';


//GRABA LOS DATOS DE LA CABCERA ================================================================
if($cabecera == 'c')
{
  $qryTempo = $conn->query("SELECT * FROM tmp WHERE idSession='$session_id'");

  if($qryTempo->num_rows>0)
  {
    // $idCarrera    = $_POST['idCarrera'];
    $idDeptoAcad  = $_POST['deptoAcad'];
    $idCurso      = $_POST['idCurso'];
    $idTipoEval   = $_POST['tipoEval'];
    $idModalidad  = $_POST['modalidad'];
    $idGrupoAlum  = $_POST['idGrupoAlum'];
    $fechaEval    = $_POST['fechaEval'];
    $semestre     = $_POST['semestre'];

    $conn->query("INSERT INTO evaluacion (idDpto, idCurso, idTipoeval, idModal, idGrupoAlumno, fechaEvaluacion, semestre, estado, eliminado) VALUES('$idDeptoAcad', '$idCurso', '$idTipoEval', '$idModalidad', '$idGrupoAlum', '$fechaEval', '$semestre', 1, 0)") or die (mysqli_error($conn));

    echo '<script type = "text/javascript">
            alert("Registro agregado correctamente.");
            window.location = "gEvaluacion.php";
          </script>';

    if($conn->affected_rows == 1)
    {
      $idEvaluacion = $conn->insert_id;

      foreach ($qryTempo as $tempo)
      {
        $idTmp        = $tempo['idTmp'];
        $idRubrica    = $tempo['idRubrica'];
        $idAlumno     = $tempo['idAlumno'];
        $idEvaluador  = $tempo['idEvaluador'];


        //CODIGO NUEVO
        $qryDetalleRubrica = $conn->query("SELECT * FROM detalle_rubrica WHERE idRubrica='$idRubrica'") or die (mysqli_error($conn));

        foreach ($qryDetalleRubrica as $detRubrica)
        {
          $idCriterio = $detRubrica['idCriterio'];

          $qryCarreraAlumno = $conn->query("SELECT * FROM alumno WHERE idAlumno='$idAlumno'") or die (mysqli_error($conn));
          $resCarreraAlumno = $qryCarreraAlumno->fetch_assoc();
          $idCarreraAlumno  = $resCarreraAlumno['idCarrera'];

          $conn->query("INSERT INTO detalle_evaluacion (idEvaluacion, idRubrica, idCriterio, idAlumno, idCarrera, idEvaluador, fechaEvaluacion, eliminado) VALUES ('$idEvaluacion','$idRubrica','$idCriterio','$idAlumno','$idCarreraAlumno','$idEvaluador', '$fechaEval', 1)") or die (mysqli_error($conn));

          if($conn->affected_rows > 0){
            $deleteTempo = mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='$idTmp' AND idSession='$session_id'");
          }

        } //FOREACH idCriterio

      }

    } //LLAVE affected_rows

  // LLAVE IF VALIDACION SI EXISTEN DATOS EN TEMPORAL
  }else { 

    echo '<script type = "text/javascript">
            alert("Debe registrar el detalle de evaluadores antes de grabar el registro.");
          </script>';
  }






} //FIN CABECERA


//GRABA LOS DATOS EN TABLA TEMPORAL =========================================================================
if($tempEval == 't')
{
  $idEvaluador  = $_POST['idEvaluador'];
  $fechaRubrica = $_POST['xIdRubrica'];
  $idGrupoAlum  = $_POST['xIdGrupoAlum'];

  $qryEvalTempo = $conn->query("SELECT * FROM tmp WHERE idEvaluador='$idEvaluador' AND idSession='$session_id'") or die(mysqli_error($conn));

  if($qryEvalTempo->num_rows==0)
  {
    $qryIdAlumno = $conn->query("SELECT idalumno FROM detalle_grupoAlumno WHERE idGrupoAl='$idGrupoAlum'") or die (mysqli_error($conn));

    foreach ($qryIdAlumno as $qryAl)
    {
      $idAlmno = $qryAl['idalumno'];

      $conn->query("INSERT INTO tmp (idRubrica, idEvaluador, idAlumno, idSession)
      SELECT idRubrica, $idEvaluador, $idAlmno ,'$session_id' FROM rubrica r
      WHERE r.fechaAprobacion = '$fechaRubrica' ") or die (mysqli_error($conn));
    }

    echo '<script type = "text/javascript">
            alert("El evaluador fue agregado satisfactoriamente.");
          </script>';

  // FIN LLAVE VALIDA DATOS DE EVALUADORES EN TEMPORAL
  } else {

    echo '<script type = "text/javascript">
            alert("El evaluador ya se encuentra registrado.");
          </script>';
  }


  $qryEval = $conn->query("SELECT t.idTmp, t.idEvaluador, nomEvaluador, apeEvaluador FROM tmp t
  LEFT JOIN evaluador e ON (e.idEvaluador = t.idEvaluador) WHERE idSession='$session_id'
  GROUP BY t.idEvaluador") or die (mysqli_error($conn));

  if($qryEval->num_rows>0)
  {
?>

<table class="table table-bordered" style="width:100%;">
  <thead>
    <tr class="alert-info">
      <th class="text-center">Nombre</th>
      <th class="text-center">Apellido</th>
      <th class="text-center"></th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($qryEval as $evals)
      {
    ?>
  <tr>
    <td><?php echo $evals['nomEvaluador'] ?></td>
    <td><?php echo $evals['apeEvaluador'] ?></td>
    <td class="text-center">
      <button type="button" name="button" class="btn btn-danger btn-sm" title="Elimina Evaluador" onclick="deleteEvaluador(<?php echo $evals['idEvaluador'] ?>,<?php echo $evals['idTmp'] ?> );">
        <span class="glyphicon glyphicon-trash"></span>
      </button>
    </td>
  </tr>
    <?php
      }
    ?>
  </tbody>
</table>

<?php
  }
}
//FIN GRABA LOS DATOS EN TABLA TEMPORAL =====================================================================


// FIN FUNCION GRABAR EVALUADORES EN TABLAS REALES =============================================
if($editaEval==1)
{
  $idEvaluacion = $_POST['xIdEvaluacion'];
  $idEvaluador  = $_POST['idEvaluador'];
  $idGrupoAlum  = $_POST['xIdGrupoAlum'];
  $fechaRubrica = $_POST['xIdRubrica'];


  $qryEvalExist = $conn->query("SELECT * FROM detalle_evaluacion WHERE idEvaluacion='$idEvaluacion' AND idEvaluador='$idEvaluador' GROUP BY idEvaluador") or die(mysqli_error($conn));

  if($qryEvalExist->num_rows==0)
  {
    $qryIdAlumno = $conn->query("SELECT idalumno FROM detalle_grupoAlumno WHERE idGrupoAl='$idGrupoAlum'") or die (mysqli_error($conn));

    foreach ($qryIdAlumno as $qryAl)
    {
      $idAlumno = $qryAl['idalumno'];

      $conn->query("INSERT INTO detalle_evaluacion (idEvaluacion, idRubrica, idAlumno, idEvaluador, eliminado)
      SELECT $idEvaluacion, idRubrica, $idAlumno, $idEvaluador, '1' FROM rubrica r
      WHERE r.fechaAprobacion = '$fechaRubrica' ") or die (mysqli_error($conn));
    }

    echo '<script type = "text/javascript">
            alert("El evaluador fue agregado satisfactoriamente.");
          </script>';

  // FIN LLAVE VALIDA DATOS DE EVALUADORES EN TEMPORAL
  } else {

    echo '<script type = "text/javascript">
            alert("El evaluador ya se encuentra registrado.");
          </script>';
  }


  $qryValores = $conn->query("SELECT * FROM detalle_evaluacion WHERE idEvaluacion='$idEvaluacion'") or die (mysqli_error($conn));

  if($qryValores->num_rows>0)
  {
?>

<table class="table table-bordered" style="width:100%;">
  <thead>
    <tr class="alert-info">
      <th class="text-center">Nombre</th>
      <th class="text-center">Apellido</th>
      <th class="text-center"></th>
    </tr>
  </thead>
  <tbody>
    <?php
      $qryEval = $conn->query("SELECT de.idEvaluador, nomEvaluador, apeEvaluador FROM detalle_evaluacion de
      LEFT JOIN evaluador e ON (e.idEvaluador = de.idEvaluador) WHERE idEvaluacion=$idEvaluacion
      GROUP BY de.idEvaluador") or die(mysqli_error($conn));

      foreach ($qryEval as $evals)
      {
    ?>
  <tr>
    <td><?php echo $evals['nomEvaluador'] ?></td>
    <td><?php echo $evals['apeEvaluador'] ?></td>
    <td class="text-center">
      <button type="button" name="button" class="btn btn-danger btn-sm" title="Elimina Evaluador" onclick="deleteEvaluador2(<?php echo $evals['idEvaluador'] ?>,<?php echo $idEvaluacion ?> );">
        <span class="glyphicon glyphicon-trash"></span>
      </button>
    </td>
  </tr>
    <?php
      }
    ?>
  </tbody>
</table>
<?php
  }
}
// FIN FUNCION GRABAR EVALUADORES EN TABLAS REALES =============================================


// FUNCION PARA ACTUALIZAR LOS DATOS DE LA CABECERA ============================================
if($updateEval == 'u')
{
  $idEvaluacion = $_POST['idEvaluacionE'];
  $idSemestre   = $_POST['semestreE'];
  $fechaRubrica = $_POST['idRubricaE'];
  $idGrupoAlum  = $_POST['idGrupoAlumE'];

  $conn->query("UPDATE evaluacion SET idGrupoAlumno='$idGrupoAlum', semestre='$idSemestre' WHERE idEvaluacion='$idEvaluacion'") or die(mysqli_error($conn));

  echo '<script type = "text/javascript">
          alert("Registro actualizado correctamente.");
          window.location = "gEvaluacion.php";
        </script>';
}

?>



<script type="text/javascript">
	function deleteEvaluador(idEvaluador, idTmp){
		$.ajax({
			type: 'POST',
			url: 'gEvaluacionEliminar.php',
			data: '&idTemporal='+idTmp+'&idEvaluadorD='+idEvaluador+'&deleteEval=d',

			beforeSend: function(objeto){
				$("#resultEvaluadores").html("Mensaje: Cargando...");
			},

			success: function(datos){
				$("#resultEvaluadores").html(datos);
			}

		}); //LLAVE AJAX
	}




  function deleteEvaluador2(idEvaluador, idEvaluacion){
		$.ajax({
			type: 'POST',
			url: 'gEvaluacionEliminar.php',
			data: '&idEvaluacionD='+idEvaluacion+'&idEvaluadorD='+idEvaluador+'&deleteEvalEdit=de',

			beforeSend: function(objeto){
				$("#resultEvaluadores").html("Mensaje: Cargando...");
			},

			success: function(datos){
				$("#resultEvaluadores").html(datos);
			}

		}); //LLAVE AJAX
	}
</script>
