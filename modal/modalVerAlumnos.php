<?php
require_once '../valid.php';

$idGrupoAlumos = $_GET['idGrupoAlum'];
?>
<div class="modal-dialog modal-md" style="width:70%;" backdrop="true">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4>Ver Alumnos</h4>
    </div>

    <div class="modal-body">
      <div class="admin_eval">
        <table id="tableGrupoAlumnos" class="table table-bordered table-hover" style="width:100%;">
          <thead>
            <tr class="alert-info">
              <th class="text-center">Nombre</th>
              <th class="text-center">Apellido</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $qryAlumnos = $conn->query("SELECT idGrupoAl, dga.idalumno, nomAlumno, apeAlumno FROM detalle_grupoAlumno dga  LEFT JOIN alumno a ON (a.idAlumno = dga.idalumno) WHERE dga.idGrupoAl='$idGrupoAlumos' AND dga.estado=1") or die(mysqli_error($conn));

            foreach ($qryAlumnos as $alumnos)
            {
            ?>
            <tr>
              <td class="text-center"><?php echo $alumnos['nomAlumno'] ?></td>
              <td class="text-center"><?php echo $alumnos['apeAlumno'] ?></td>
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
