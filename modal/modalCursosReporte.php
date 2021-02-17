<?php
require_once '../valid.php';

$nivelAporte  = $_GET['tipoaporte'];
$idObGral     = $_GET['idObjgeneral'];

$qryCursos = $conn->query("SELECT
    dcn.idCurso, c.nombreCurso, dcn.tipoaporte
FROM
    detalle_curso_nivelaporte dcn
        LEFT JOIN
    curso c ON (c.idCurso = dcn.idCurso)
WHERE
    tipoaporte IN ($nivelAporte)
        AND idObjgeneral = '$idObGral' GROUP BY dcn.idCurso") or die(mysqli_error($conn));

?>
<div class="modal-dialog modal-md" style="width:50%;" backdrop="true">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4>Ver Cursos</h4>
    </div>

    <div class="modal-body">
      <div class="admin_eval">
        <table class="table table-bordered" style="width:100%;">
          <thead>
            <tr class="alert-info">
              <th class="text-center">Curso</th>
              <th class="text-center">Nivel de aporte</th>
            </tr>
          </thead>
          <tbody>
            <?php
    foreach ($qryCursos as $cursos)
    {
    ?>
    <tr>
      <td><?php echo $cursos['nombreCurso'] ?></td>
      <?php
        if($cursos['tipoaporte'] == 1){
          $nomAporte = 'Contribuye';
        ?>
          <td class="text-center"><?php echo $nomAporte ?></td>
        <?php
      }else if($cursos['tipoaporte'] == 2){
          $nomAporte = 'Logra';
        ?>
          <td class="text-center"><?php echo $nomAporte ?></td> 
        <?php
      }else if($cursos['tipoaporte'] == 3){
          $nomAporte = 'Sostiene';
        ?>
          <td class="text-center"><?php echo $nomAporte ?></td>
        <?php
      }else if($cursos['tipoaporte'] == 4){
          $nomAporte = 'No aplica';
        ?>
          <td class="text-center"><?php echo $nomAporte ?></td>
        <?php
        }

      ?>

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
