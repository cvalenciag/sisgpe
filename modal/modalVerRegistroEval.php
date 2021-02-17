<?php
require_once '../valid.php';

$idEvaluacion = $_GET['idEvaluacion'];

$qryEvals = $conn->query("SELECT
    d.nombreCorto,
    c.nombreCurso,
    te.descripcion AS descEvaluacion,
    IF(e.idModal = 1, 'Escrito', 'Oral') AS tipoModalidad,
    e.fechaEvaluacion,
    e.semestre,
    ga.descripcion AS descProyecto,
    r.fechaAprobacion AS fechaRubrica
FROM
    evaluacion e
        LEFT JOIN
    detalle_evaluacion de ON (de.idEvaluacion = e.idEvaluacion)
        LEFT JOIN
    departamento d ON (d.idDepartamento = e.idDpto)
        LEFT JOIN
    curso c ON (c.idCurso = e.idCurso)
        LEFT JOIN
    tipo_evaluacion te ON (te.idTipoEval = e.idTipoeval)
        LEFT JOIN
    grupoAlumno ga ON (ga.idGrupoAl = e.idGrupoAlumno)
        LEFT JOIN
    rubrica r ON (r.idCurso = e.idCurso)
WHERE
    e.idEvaluacion = '$idEvaluacion'
GROUP BY e.idEvaluacion") or die(mysqli_error($conn));
$resultEvals = $qryEvals->fetch_array();

?>
<div class="modal-dialog modal-md" style="width:70%;" backdrop="true">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4>Ver Evaluación</h4>
    </div>

    <div class="modal-body">
      <div class="admin_eval">
        <label><b>Departamento académico: </b></label> <?php echo $resultEvals['nombreCorto'] ?>
        <br>
        <label><b>Curso: </b></label> <?php echo $resultEvals['nombreCurso'] ?>
        <br>
        <label><b>Fecha de rúbrica: </b></label> <?php echo $resultEvals['fechaRubrica'] ?>
        <br>
        <label><b>Tipo de evaluación: </b></label> <?php echo $resultEvals['descEvaluacion'] ?>
        <br>
        <label><b>Modalidad: </b></label> <?php echo $resultEvals['tipoModalidad'] ?>
        <br>
        <label><b>Fecha de evaluación: </b></label> <?php echo $resultEvals['fechaEvaluacion'] ?>
        <br>
        <label><b>Semestre: </b></label> <?php echo $resultEvals['semestre'] ?>
        <br>
        <label><b>Nombre del proyecto: </b></label> <?php echo $resultEvals['descProyecto'] ?>

        <br><br>
        <label>Grupo de Alumnos</label><br>
        <table class="table table-bordered" style="width:100%;">
          <thead>
            <tr class="alert-info">
              <th class="text-center">Código SII</th>
              <th class="text-center">Nombres</th>
              <th class="text-center">Apellidos</th>
              <th class="text-center">Carrera</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $qryAlumnos = $conn->query("SELECT
    a.codSII,
    a.nomAlumno,
    a.apeAlumno,
    c.descripcion AS descCarrera
FROM
    detalle_grupoAlumno dg
        LEFT JOIN
    evaluacion e ON (e.idGrupoAlumno = dg.idGrupoAl)
        LEFT JOIN
    alumno a ON (a.idAlumno = dg.idalumno)
        LEFT JOIN
    carrera c ON (c.idCarrera = a.idCarrera)
WHERE
    e.idEvaluacion = '$idEvaluacion'") or die(mysqli_error($conn));

    foreach ($qryAlumnos as $qryAl)
    {
    ?>
    <tr>
      <td><?php echo $qryAl['codSII'] ?></td>
      <td><?php echo $qryAl['nomAlumno'] ?></td>
      <td><?php echo $qryAl['apeAlumno'] ?></td>
      <td><?php echo $qryAl['descCarrera'] ?></td>
    </tr>
    <?php
    }
    ?>

          </tbody>
        </table>

        <br><br>
        <label>Evaluadores</label><br>
        <table class="table table-bordered">
          <thead>
            <tr class="alert-info">
              <th class="text-center">DNI</th>
              <th class="text-center">Nombres</th>
              <th class="text-center">Apellidos</th>
              <th class="text-center">Cargo</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $qryEvalua = $conn->query("SELECT
    e.dniEvaluador,
    e.nomEvaluador,
    e.apeEvaluador,
    cc.descripcion as cargoEvaluador
FROM
    detalle_evaluacion de
        LEFT JOIN
    evaluador e ON (e.idEvaluador = de.idEvaluador)
        LEFT JOIN
    cargo cc ON (cc.idCargo=e.idCargo)
WHERE
    de.idEvaluacion = '$idEvaluacion'
GROUP BY de.idEvaluador") or die(mysqli_error($conn));

            foreach ($qryEvalua as $qeval)
            {
            ?>
            <tr>
              <td><?php echo $qeval['dniEvaluador'] ?></td>
              <td><?php echo $qeval['nomEvaluador'] ?></td>
              <td><?php echo $qeval['apeEvaluador'] ?></td>
              <td><?php echo $qeval['cargoEvaluador'] ?></td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
  </div>
</div>
