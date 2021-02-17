<?php
  // require_once 'connect.php';
  require_once 'valid.php';
  $idUser       = $_SESSION['admin_id'];
  $idEvaluacion = $_REQUEST['idEvaluacion'];


  $qryIdEvaluador = $conn->query("SELECT * FROM evaluador WHERE idUsuario=$idUser") or die(mysqli_error($conn));
  $resIdEvaluador = $qryIdEvaluador->fetch_assoc();
  $idEvaluador    = $resIdEvaluador['idEvaluador'];


  $qryNameUser = $conn->query("SELECT CONCAT(nombre,' ', apellido) AS nameUser FROM usuario WHERE idUsuario=$idUser") or die(mysqli_error($conn));
  $resNameUser = $qryNameUser->fetch_assoc();
  $nameUser    = $resNameUser['nameUser'];


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
  $fechaRubrica = $resDetEval['fechaEvaluacion'];

?>
<!DOCTYPE html>
<head>
    <?php require("head.php"); ?>
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
        <input type="hidden" name="" value="<?php echo $nameMod ?>" id="modalidad">
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
  <a href="#" id="reportePDF" onclick=""><img src="images/descargar.png" style="width:30px;height:30px;" title="Descargar informe del proyecto"></a>&nbsp;
  <a href="#" id="reportePDF" onclick="exportPDF(<?php
  echo $idEvaluacion.','.$idUser ?>)"><img src="images/pdf.png" style="width:30px;height:30px;" title="Exportar Rubrica a PDF"></a>&nbsp;
  <a href="#" id="reportePrint" onclick="javascript:window.print();"><img src="images/print.png" style="width:30px;height:30px;" title="Imprimir Rubrica"></a>
  <br>
  <br>

  <table id="tableEvaluation" class="table table-bordered" style="width:100%;">
    <thead>
      <tr class="bg-primary">
        <th class="text-center" style="width:10%;">Competencia</th>
        <th class="text-center" style="width:10%;">Obj. aprendizaje</th>
        <th class="text-center" style="width:10%;">Criterios</th>

        <?php
          $qryNiveles = $conn->query("SELECT s.idNivel, dr.idRubrica, n.descripcion FROM subcriterio s
            LEFT JOIN detalle_rubrica dr USING (idCriterio)
            LEFT JOIN nivel n USING (idNivel)
            WHERE idRubrica = '$idRubrica' GROUP BY s.idNivel ORDER BY IF(s.rango=1,
            s.total, s.minimo)") or die(mysqli_error($conn));

          foreach ($qryNiveles as $niveles)
          {
        ?>
          <th class="text-center" style="width:10%"><?php echo $niveles['descripcion'] ?></th>
        <?php
          }
        ?>


        <?php
        $qryAlums = $conn->query("SELECT idEvaluacion, idRubrica, nomAlumno, apeAlumno
          FROM detalle_evaluacion de LEFT JOIN alumno a ON (a.idAlumno = de.idAlumno)
          WHERE idEvaluacion='$idEvaluacion' GROUP BY de.idAlumno") or die(mysqli_error($conn));

        if($nameMod == 1)
        {
        ?>
          <th class="text-center" colspan="<?php echo $qryAlums->num_rows ?>" style="width:5%">Puntaje</th>
        <?php
        }else {
          $i=1;
          foreach ($qryAlums as $alums)
          {
        ?>
          <th class="text-center" style="width:5%"><?php echo 'A'.$i ?></th>
        <?php
          $i++;
          }
        }
        ?>
      </tr>
    </thead>
    <tbody>
      <?php
        $qryRubricas = $conn->query("SELECT r.idRubrica, r.ordenamiento, r.idCompetencia, IF(r.idCompetencia != - 1,
        cc.descripcion, 'No Aplica') AS desCompetencia, r.idObjetivoGeneral, IF(r.idObjetivoGeneral != - 1,
        objg.definicion, 'No Aplica') AS desObjGral, r.idCriterio, c.descripcion AS desCriterio
        FROM detalle_rubrica r LEFT JOIN criterio c ON (c.idCriterio = r.idCriterio)
        LEFT JOIN competencia cc ON (cc.idCompetencia = r.idCompetencia)
        LEFT JOIN objgeneral objg ON (objg.idObjgeneral = r.idObjetivoGeneral)
        WHERE r.idRubrica = '$idRubrica' ORDER BY r.ordenamiento") or die(mysqli_error($conn));

        foreach ($qryRubricas as $rubricas)
        {
          $idCriterio = $rubricas['idCriterio'];
      ?>
      <tr class="alert-info">
        <th></th>
        <th></th>
        <th class="text-center">Puntaje</th>
        <?php
          if('rango' == 1){
            $orderBy = 'ORDER BY s.total';
          }else {
            $orderBy = 'ORDER BY s.minimo';
          }

          $qryNiveles = $conn->query("SELECT s.idNivel, dr.idRubrica, n.descripcion,
            s.rango, s.total, s.maximo, s.minimo FROM subcriterio s
            LEFT JOIN detalle_rubrica dr USING (idCriterio)
            LEFT JOIN nivel n USING (idNivel)
            WHERE idRubrica = '$idRubrica' AND idCriterio='$idCriterio' ORDER BY IF(s.rango=1,
            s.total, s.minimo)") or die(mysqli_error($conn));

          foreach ($qryNiveles as $niveles)
          {
            if($nameMod==1 && $niveles['rango'] == 1)
            {
        ?>
              <th class="text-center"><?php echo $niveles['total'] ?></th>
        <?php
            }else if($nameMod==1 && $niveles['rango'] == 2){
        ?>
              <th class="text-center"><?php echo $niveles['minimo'].' - '.$niveles['maximo'] ?></th>
        <?php
            }else if($nameMod==2 && $niveles['rango'] == 1){
        ?>
              <th class="text-center"><?php echo $niveles['total'] ?></th>
        <?php
            }else if($nameMod==2 && $niveles['rango'] == 2){
        ?>
              <th class="text-center"><?php echo $niveles['minimo'].' - '.$niveles['maximo'] ?></th>
        <?php
            }
          } //LLAVE FOREACH NIVELES
        ?>

        <?php
        $qryAlums = $conn->query("SELECT idEvaluacion, idRubrica, de.idAlumno, nomAlumno, apeAlumno,
          puntajeEvaluador, idCriterio FROM detalle_evaluacion de
          LEFT JOIN alumno a ON (a.idAlumno = de.idAlumno)
          WHERE idEvaluacion='$idEvaluacion' AND idCriterio='$idCriterio' GROUP BY de.idAlumno") or die(mysqli_error($conn));
        $resAlums = $qryAlums->fetch_assoc();

        if($nameMod==1)
        {
        ?>
          <td class="text-center" colspan="<?php echo $qryAlums->num_rows ?>">
            <input type="numberbox" name="" value="<?php echo $resAlums['puntajeEvaluador'] ?>" id="alumno_<?php echo $resAlums['idRubrica'].'_'.$resAlums['idCriterio'] ?>" style="width:120px;" onchange="updatePuntajeEscrito(this.id);" onkeypress="return justNumbers(event);">
          </td>
        <?php
        }else {
          $i=1;
          foreach ($qryAlums as $alums) 
          {
        ?>
          <td class="text-center">
            <input type="numberbox" name="" value="<?php echo $alums['puntajeEvaluador'] ?>" id="alumno_<?php echo $alums['idRubrica'].'_'.$alums['idCriterio'].'_'.$alums['idAlumno'] ?>" style="width:45px;" onchange="updatePuntajeOral(this.id);" onkeypress="return justNumbers(event);">
          </td>
        <?php
          $i++;
          }
        }
        ?>
      </tr>

      <tr>
        <td class="<?php echo $rubricas['idCompetencia'] != '-1' ? "text-justify" : "text-center" ?>"><?php echo $rubricas['desCompetencia'] ?></td>
          <td class="<?php echo $rubricas['idObjetivoGeneral'] != '-1' ? "text-justify" : "text-center" ?>"><?php echo $rubricas['desObjGral'] ?></td>
          <td><?php echo $rubricas['desCriterio'] ?></td>

          <?php
            $qrySubCriterios = $conn->query("SELECT * FROM subcriterio WHERE idCriterio='$idCriterio' ORDER BY IF(rango=1, total, minimo)") or die(mysqli_error($conn));

            foreach ($qrySubCriterios as $subCri)
            {
          ?>
              <td><?php echo $subCri['descripcion'] ?></td>
          <?php
            }
          ?>
          <td colspan="<?php echo $qryAlums->num_rows ?>" class="text-left">
            <?php
              $qryObs = $conn->query("SELECT idRubrica, idCriterio, observacion FROM detalle_evaluacion WHERE idEvaluacion='$idEvaluacion' AND idCriterio='$idCriterio' GROUP BY idEvaluacion") or die(mysqli_error($conn));
              $resObs = $qryObs->fetch_assoc();
            ?>
            <b>Observación:</b><br>
            <textarea class='form-control' cols="8" rows="8" id="obs_<?php echo $resObs['idRubrica'].'_'.$resObs['idCriterio'] ?>" onchange="updateObservacion(this.id);">
              <?php echo $resObs['observacion'] ?>
            </textarea>
          </td>
      </tr>

      <?php
        } //  LLAVE FOREACH COMPETENCIAS
      ?>

      <tr class="bg-primary">
        <th colspan="7" class="text-right">Total:</th>
        <th colspan="3"></th>
        <!-- <?php
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
        ?> -->
      </tr>
    </tbody>
    <tfoot>
      <table style="width:100%;">
        <tr>
          <th colspan="2">Comentarios:</th>
        </tr>
        <tr>
          <td>
            <?php
              $qryComentario = $conn->query("SELECT comentario FROM detalle_evaluacion WHERE idEvaluacion='$idEvaluacion' AND idEvaluador='$idEvaluador' GROUP BY idEvaluacion") or die(mysqli_error($conn));
              $resComentario = $qryComentario->fetch_assoc();
            ?>
            <textarea name="name" rows="3" style="width:900px" onchange="updateComentarios();" id="comentarioEval">
              <?php echo $resComentario['comentario'] ?>
            </textarea>
          </td>
          <td>
            <button class="btn btn-lg btn-warning" name="finalizarEval" onclick="finalizarEvaluacion(<?php echo $idEvaluacion.','.$idEvaluador ?>);">
              <span class="glyphicon glyphicon-ok"></span>
              <b>Finalizar</b>
            </button>
          </td>
        </tr>
      </table>
    </tfoot>
  </table>
</div>
</div>
<br><br><br><br>
<?php require("footer.php"); ?>
<script type="text/javascript" src="js/gIniciarEvaluacion.js"></script>

<script type="text/javascript">
function justNumbers(e)
{
  var keynum = window.event ? window.event.keyCode : e.which;
  if ((keynum == 8) || (keynum == 46))
  return true;

  return /\d/.test(String.fromCharCode(keynum));
}

</script>
</html>
