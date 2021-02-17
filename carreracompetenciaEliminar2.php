<?php
require_once 'valid.php';
$session_id   = $_SESSION['session_id'];
$idTemp = (isset($_REQUEST['id']) && !empty($_REQUEST['id']))?$_REQUEST['id']:'';
$fAprobacion  = (isset($_REQUEST['fAprobacion']) && !empty($_REQUEST['fAprobacion']))?$_REQUEST['fAprobacion']:'';


$sqlDelete = $conn->query("SELECT * FROM tmp WHERE idTmp='$idTemp'");
if($sqlDelete->num_rows==1){

  $deleteTmp = mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$idTemp."'");
}


// MUESTRA LOS DATOS DE LA TABLA TEMPORAL ==================
$sql=$conn->query("SELECT * FROM competencia, tmp WHERE competencia.idCompetencia=tmp.idCompetencia AND tmp.fAprobacion = '$fAprobacion' AND tmp.idSession='".$session_id."'");
// $sql=$conn->query("SELECT * FROM competencia, tmp WHERE competencia.idCompetencia=tmp.idCompetencia AND tmp.fAprobacion = '$fAprobacion'");

if ($sql->num_rows>0)
{
?>

  <table class="table table-bordered" style="width:100%;">
    <tr class="alert-info">
      <th class='text-center'>Competencia</th>
      <th class='text-center'>Ordenamiento</th>
      <th></th>
    </tr>
  <?php
  while ($row=mysqli_fetch_array($sql))
  {
    $id_tmp=$row["idTmp"];
    $descripcion=$row['descripcion'];
    $ordenamiento=$row['ordenamiento'];
  ?>

    <tr>
      <td class='text-center'><?php echo $descripcion;?></td>
      <td class='text-center'><?php echo $ordenamiento;?></td>

      <td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp; ?>)"><i class="btn btn-sm btn-danger glyphicon glyphicon-trash"></i></a></td>
    </tr>

  <?php
  }
  ?>

  </table>
<?php
}
?>
