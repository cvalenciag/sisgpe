<?php
require_once 'valid.php';
$session_id   = $_SESSION['session_id'];
$idTmp        = $_POST["id"];
$fAprobacion  = $_POST["fAprobacion"];


$sqlDelete = $conn->query("SELECT * FROM tmp WHERE idTmp='$idTmp'");
if($sqlDelete->num_rows==1){

  $deleteTmp = mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$idTmp."'");
}


// MUESTRA LOS DATOS DE LA TABLA TEMPORAL ==================
$sql = $conn->query("SELECT * FROM curso c, tmp t WHERE c.idCurso=t.idCurso AND fAprobacion='".$fAprobacion."' AND t.idSession='".$session_id."'");

  if ($sql->num_rows > 0)
  {
?>
  <table class="table table-bordered" style="width:100%;">
    <tr class="alert-info">
      <th class='text-center'>Curso</th>
      <th class='text-center'>Ciclo</th>
      <th class='text-center'>Obligatoriedad</th>
      <th class='text-center'>AOL</th>
      <th></th>
    </tr>
<?php
    while ($row=mysqli_fetch_array($sql))
    {
      $id_tmp       = $row["idTmp"];
      $nombreCurso  = $row['nombreCurso'];
      $ciclo        = $row['ciclo'];
      $obligatorio  = $row['obligatorio'];
      $aol          = $row['aol'];

?>
      <tr>
        <td class='text-justify'><?php echo $nombreCurso;?></td>
        <td class='text-center'><?php echo $ciclo;?></td>
        <td class='text-center'><?php echo ($obligatorio==1) ? "Obligatorio" : "Electivo"?></td>
        <td class='text-center'><?php echo ($aol==1) ? "Si" : "No"?></td>

        <td class='text-center'>
          <button type="button" name="button" class="btn btn-danger btn-sm glyphicon glyphicon-trash"
                  onclick="eliminarCurso('<?php echo $id_tmp; ?>')">
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
