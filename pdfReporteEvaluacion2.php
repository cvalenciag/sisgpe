<?php
require_once ('connect.php');
set_time_limit(500);

$idUser       = $_REQUEST['idUsuario'];
$idEvaluacion = $_REQUEST['idEvaluacion'];


$qryIdEvaluador = $conn->query("SELECT * FROM evaluador WHERE idUsuario=$idUser") or die(mysqli_error($conn));
$resIdEvaluador = $qryIdEvaluador->fetch_assoc();
$idEvaluador    = $resIdEvaluador['idEvaluador'];


$qryNameUser = $conn->query("SELECT CONCAT(nombre,' ', apellido) AS nameUser FROM usuario WHERE idUsuario=$idUser") or die(mysqli_error($conn));
$resNameUser = $qryNameUser->fetch_assoc();
$nameUser    = $resNameUser['nameUser'];

// $fechaRubrica = $_REQUEST['fechaRubrica'];

$qryResultadosEval = $conn->query("SELECT idEvaluacion, e.idDpto, d.descripcion AS nomDepto, e.idCurso, nombreCurso, e.idTipoeval, te.descripcion AS nomTipoEval, e.idModal, e.fechaEvaluacion, idGrupoAlumno, e.semestre, ga.descripcion FROM evaluacion e
LEFT JOIN departamento d ON (d.idDepartamento = e.idDpto)
LEFT JOIN curso c ON (c.idCurso = e.idCurso)
LEFT JOIN grupoAlumno ga ON (ga.idGrupoAl = e.idGrupoAlumno)
LEFT JOIN tipo_evaluacion te ON (te.idTipoEval = e.idTipoeval) WHERE idEvaluacion='$idEvaluacion'") or die(mysqli_error($conn));
$resQryREval = $qryResultadosEval->fetch_array();

$idCurso    = $resQryREval['idCurso'];
$nameCurso  = $resQryREval['nombreCurso'];
$nameMod    = $resQryREval['idModal'];
$nameProy   = $resQryREval['descripcion'];
$semestre   = $resQryREval['semestre'];

$qryDetEval = $conn->query("SELECT * FROM detalle_evaluacion WHERE idEvaluacion='$idEvaluacion'") or die(mysqli_error($conn));
$resDetEval   = $qryDetEval->fetch_array();
$idRubrica    = $resDetEval['idRubrica'];
$fRubrica     = $resDetEval['fechaEvaluacion'];
$fechaRubrica = substr($fRubrica, 0, -9);

// echo $fechaRubrica;

?>

<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name = "viewport" content = "width=device-width, initial-scale=1" />
	<link rel = "stylesheet" type = "text/css" href = "css/bootstrap.css" />
  <link rel = "stylesheet" type = "text/css" href = "css/chosen.min.css" />
  <link rel = "stylesheet" type = "text/css" href = "css/main.css" />
</head>
<div class="container-fluid">
<div class="col-lg-12" style="margin-top:125px;">
<table style="width:100%;">
  <tr class="bg-primary">
    <!-- <td class="text-left" style="width:20%;"><img src="images/UP LOGO.png"  /></td> -->
    <td colspan="2" class="text-center"><b>RUBRICA PARA EVALUACION DEL CURSO:</b>
      <!-- <font color="#337ab7"> -->
        <?php echo $nameCurso ?> &nbsp;&nbsp; ( MODALIDAD: <?php echo $nameMod==1 ? 'Escrito' : 'Oral'  ?> )
      <!-- </font> -->
      <input type="hidden" name="" value="<?php echo $idEvaluacion ?>" id="idEvaluacion">
      <input type="hidden" name="" value="<?php echo $idEvaluador ?>" id="isEvaluador">
    </td>
  </tr>
</table>
</div>

<div class="col-lg-12" style="margin-top:15px;">
<table style="width:100%;">
  <tr>
    <td style="width:250px;"><b>NOMBRE DEL PROYECTO:</b></td>
    <td class="text-left"><font color="#337ab7"><?php echo $nameProy ?></font></td>
    <td class="text-right" style="width:50px;"><b>Login:</b></td>
    <td class="text-center" style="width:250px;">
      <font color="#337ab7"><?php echo $nameUser ?></font>
    </td>
  </tr>
</table>
</div>

<div class="col-lg-12" style="margin-top:15px;">
<table style="width:100%;">
  <tr>
    <td>
      <table style="width:100%;">
        <tr>
          <td style="width:250px;"><b>INTEGRANTES DEL GRUPO:</b></td>
          <?php
          $qryAlums = $conn->query("SELECT idEvaluacion, idRubrica, nomAlumno, apeAlumno
            FROM detalle_evaluacion de LEFT JOIN alumno a ON (a.idAlumno = de.idAlumno)
            WHERE idEvaluacion='$idEvaluacion' GROUP BY de.idAlumno") or die(mysqli_error($conn));

            $i=1;
            foreach ($qryAlums as $alums)
            {
          ?>
            <td><font color="#337ab7"><?php echo 'A'.$i.': '.$alums['nomAlumno'].' '.$alums['apeAlumno'] ?></font></td>
          <?php
              $i++;
            }
          ?>
        </tr>
      </table>
    </td>
    <td class="text-center"><b>SEMESTRE:</b></td>
    <td class="text-center"><font color="#337ab7"><?php echo $semestre ?></font></td>
  </tr>
</table>
</div>

<div class="col-lg-12" style="margin-top:25px;">
<table id="tableEvaluation" class="table table-bordered" style="width:100%;">
  <thead>
    <tr class="bg-primary">
      <th class="text-center" style="width:15%">Competencia</th>
      <th class="text-center" style="width:15%">Obj. aprendizaje</th>
      <th class="text-center" style="width:15%">Criterios</th>
      <?php
        // $qryNivel = $conn->query("SELECT * FROM nivel WHERE estado=1 ORDER BY idNivel") or die(mysqli_error($conn));
        $qryNivel = $conn->query("SELECT
  idEvaluacion, dr.idNivel, n.descripcion
FROM
  detalle_evaluacion de
      LEFT JOIN
  detalle_rubrica dr ON (dr.idRubrica = de.idRubrica)
      LEFT JOIN
  nivel n ON (n.idNivel = dr.idNivel)
      LEFT JOIN
  rubrica r ON (r.idRubrica = de.idRubrica)
WHERE
  idEvaluacion = $idEvaluacion
GROUP BY dr.idNivel") or die(mysqli_error($conn));

        foreach ($qryNivel as $nivel){
      ?>
        <th class="text-center" style="width:10%"><?php echo $nivel['descripcion'] ?></th>
      <?php
        }
      ?>

      <?php
        $qryAlums = $conn->query("SELECT idEvaluacion, idRubrica, nomAlumno, apeAlumno
          FROM detalle_evaluacion de LEFT JOIN alumno a ON (a.idAlumno = de.idAlumno)
          WHERE idEvaluacion='$idEvaluacion' GROUP BY de.idAlumno") or die(mysqli_error($conn));

        $i=1;
        foreach ($qryAlums as $alums){
      ?>
        <th class="text-center" style="width:5%"><?php echo 'A'.$i ?></th>
      <?php
        $i++;
        }
      ?>
    </tr>
  </thead>
  <tbody>
    <?php
      $qryCriterios = $conn->query("SELECT
  de.idEvaluacion,
  de.idRubrica,
  r.idCompetencia,
  IF(r.idCompetencia != 0,
      cc.definicion,
      'No Aplica') AS desCompetencia,
  r.idObjetivoGeneral,
  IF(r.idObjetivoGeneral != 0,
      objg.definicion,
      'No Aplica') AS desObjGral,
  r.idCriterio,
  c.descripcion AS desCriterio,
  observacion
FROM
  detalle_evaluacion de
      LEFT JOIN
  rubrica r ON (r.idRubrica = de.idRubrica)
      LEFT JOIN
  criterio c ON (c.idCriterio = r.idCriterio)
      LEFT JOIN
  competencia cc ON (cc.idCompetencia = r.idCompetencia)
      LEFT JOIN
  objgeneral objg ON (objg.idObjgeneral = r.idObjetivoGeneral)
WHERE
  de.idEvaluacion = '$idEvaluacion' AND idEvaluador='$idEvaluador'
GROUP BY de.idRubrica") or die(mysqli_error($conn));

      foreach ($qryCriterios as $criterio)
      {
        $idCriterio = $criterio['idCriterio'];
        $idRubrica  = $criterio['idRubrica'];
    ?>
      <tr class="alert-info">
        <th></th>
        <th></th>
        <th class="text-center">Puntaje</th>

        <?php
          $qryX = $conn->query("SELECT dr.idRubrica, dr.idNivel, dr.ordNivel, dr.idSubcri, s.descripcion AS desSubcri, dr.puntajeRango, r.idCriterio FROM detalle_rubrica dr
          LEFT JOIN rubrica r USING (idRubrica) LEFT JOIN subcriterio s ON (s.idSubcriterio = dr.idSubcri) WHERE r.idCriterio='$idCriterio' ORDER BY r.idCriterio , idNivel") or die(mysqli_error($conn));
          // r.idCriterio='$idCriterio' AND fechaAprobacion='$fechaRubrica' ORDER BY r.idCriterio , idNivel") or die(mysqli_error($conn));

          foreach ($qryX as $x)
          {
          ?>
            <th class="text-center"><?php echo $x['puntajeRango']  ?></th>
          <?php
          }

            $qryAlums = $conn->query("SELECT de.idEvaluacion, de.idRubrica, de.idAlumno, nomAlumno, apeAlumno, puntajeEvaluador FROM detalle_evaluacion de LEFT JOIN alumno a ON (a.idAlumno = de.idAlumno)
            WHERE idEvaluacion='$idEvaluacion' AND idEvaluador='$idEvaluador' AND idRubrica='$idRubrica'") or die(mysqli_error($conn));
            // GROUP BY de.idAlumno") or die(mysqli_error($conn));

            // $i=1;
            foreach ($qryAlums as $alums)
            {
          ?>
          <td class="text-center" style="width:45px;">
            <?php echo $alums['puntajeEvaluador'] ?>
          </td>
          <?php
            // $i++;
          }
        ?>
      </tr>

      <tr>
        <td class="<?php echo $criterio['idCompetencia'] !=0 ? "text-left" : "text-center" ?>"><?php echo $criterio['desCompetencia'] ?></td>
        <td class="<?php echo $criterio['idObjetivoGeneral'] !=0 ? "text-left" : "text-center" ?>"><?php echo $criterio['desObjGral'] ?></td>
        <td><?php echo $criterio['desCriterio'] ?></td>

        <?php
          $qrySubCri = $conn->query("SELECT dr.idRubrica, dr.idNivel, dr.ordNivel, dr.idSubcri,
          s.descripcion AS desSubcri, dr.puntajeRango, r.idCriterio FROM detalle_rubrica dr
          LEFT JOIN rubrica r USING (idRubrica)  LEFT JOIN subcriterio s ON (s.idSubcriterio = dr.idSubcri)
          WHERE r.idCriterio='$idCriterio' ORDER BY idNivel") or die(mysqli_error($conn));
          foreach ($qrySubCri as $subcri)
          {
          ?>
            <td><?php echo $subcri['desSubcri'] ?></td>
          <?php
          }
        ?>
          <td colspan="<?php echo $qryAlums->num_rows ?>" class="text-left">
            <b>Observación:</b><br>
            <?php echo $criterio['observacion'] ?>
          </td>
      </tr>
    <?php
      } //LLAVE CRITERIOS

      $qrysNiveles = $conn->query("SELECT
  *
FROM
  detalle_evaluacion de
      LEFT JOIN
  detalle_rubrica dr ON (dr.idRubrica = de.idRubrica)
      LEFT JOIN
  nivel n ON (n.idNivel = dr.idNivel)
      LEFT JOIN
  rubrica r ON (r.idRubrica = de.idRubrica)
WHERE
  idEvaluacion = $idEvaluacion
GROUP BY dr.idNivel") or die(mysqli_error($conn));

    $totalNiveles   = $qrysNiveles->num_rows;
    $totalColumnas  = $totalNiveles + 3;
    ?>
    <tr class="bg-primary">
      <th colspan="<?php echo $totalColumnas ?>" class="text-right">Total:</th>
      <?php
      $qryAlumns = $conn->query("SELECT de.idEvaluacion, de.idAlumno, SUM(puntajeEvaluador) totalAlum FROM detalle_evaluacion de LEFT JOIN alumno a ON (a.idAlumno = de.idAlumno)
      WHERE idEvaluacion='$idEvaluacion' AND idEvaluador='$idEvaluador' GROUP BY de.idAlumno") or die(mysqli_error($conn));

      foreach ($qryAlumns as $alms)
      {
      ?>
        <th class="text-right" id="alm_<?php echo $alms['idAlumno'] ?>">
          <?php echo $alms['totalAlum'] ?>
        </th>
      <?php
      }
      ?>
    </tr>
  </tbody>
</table>
<table style="width:100%;">
  <tr>
    <th colspan="7" class="text-left">Comentarios:</th>
  </tr>
  <tr>
    <td colspan="7" class="text-justify">
      <?php
        $qryComentario = $conn->query("SELECT comentario FROM detalle_evaluacion WHERE idEvaluacion='$idEvaluacion' AND idEvaluador='$idEvaluador' GROUP BY idEvaluacion") or die(mysqli_error($conn));
        $resComentario = $qryComentario->fetch_assoc();

        echo $resComentario['comentario']
      ?>
    </td>
  </tr>
</table>
</div>
</div>
