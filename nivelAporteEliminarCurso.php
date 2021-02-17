<?php

require_once 'valid.php';
$session_id   = $_SESSION['session_id'];
$idTmp        = $_REQUEST['id'];


$sqlDelete = $conn->query("SELECT * FROM tmp WHERE idTmp='$idTmp'");
if($sqlDelete->num_rows==1){
  $deleteTmp = mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$idTmp."'");
}

// MUESTRA LOS DATOS DE LA TABLA TEMPORAL
$sql = $conn->query("SELECT * FROM curso c, tmp t, departamento d WHERE c.idCurso=t.idCurso AND c.idDepartamento=d.idDepartamento AND t.idSession='".$session_id."'");
if ($sql->num_rows > 0)
{
?>
  <table id="tableCursos" class="table table-bordered" style="width:100%;">
    <tr class="alert-info">
      <th class="text-center" style="width:30%;">Curso</th>
      <th class="text-center" style="width:10%;">Ciclo</th>
      <th class="text-center" style="width:25%;">Departamento <br> Académico</th>
      <th class="text-center" style="width:15%;">Tipo <br> Curso</th>
      <th class="text-center" style="width:10%;">AoL</th>
      <th class="text-center" style="width:10%;">Asocial Objetivos <br> de Aprendizaje</th>
      <th></th>
    </tr>
  <?php
    while ($row = mysqli_fetch_array($sql))
    {
      $id_tmp       = $row["idTmp"];
      $nombreCurso  = $row['nombreCurso'];
      $idCurso      = $row['idCurso'];
      $ciclo        = $row['ciclo'];
      $aol          = $row['aol'];
      $tipoCurso    = $row['tipoCurso'];
      $idDepartamento   = $row['idDepartamento'];
      $descDepartamento = $row['descripcion'];
  ?>
    <tr>
      <td class='text-center'><?php echo $nombreCurso; ?></td>
      <td class='text-center'><?php echo $ciclo; ?></td>
      <td class='text-center'><?php echo $descDepartamento; ?></td>
      <td class="text-center"><?php echo ($tipoCurso==1) ? "Académico" : "Para-Académico" ?></td>
      <td class='text-center'><?php echo ($aol==1) ? "Si" : "No"?></td>
      <td class='text-center'>
        <button type="button" name="button" class="btn btn-editar vadmin_id" data-toggle="modal" data-target="#miModal" value="<?php echo $idCurso ?>">
          <span></span>
            Objetivos de Aprendizaje
        </button>
      </td>
      <td class='text-center'>
        <button type="button" name="button" class="btn btn-danger btn-sm glyphicon glyphicon-trash deladmin_id" value="<?php echo $id_tmp; ?>">
        </button>
      </td>
    </tr>
  <?php
    }
  ?>
  </table>
<?php
  }
?>
