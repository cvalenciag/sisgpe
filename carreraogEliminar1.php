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
$sql  = $conn->query("SELECT * FROM objgeneral ob, tmp t WHERE ob.idObjgeneral=t.idObjgeneral AND t.fAprobacion='$fAprobacion' AND t.idSession='".$session_id."'");

if ($sql->num_rows>0)
{

?>

  <table class="table table-bordered" style="width:100%;">
    <tr class = "alert-info">
      <th class='text-center'>Objetivo general</th>
      <th class='text-center'>Ordenamiento</th>
      <th></th>
    </tr>

    <?php
    while ($row=mysqli_fetch_array($sql))
    {
      $id_tmp       = $row["idTmp"];
      $definicion   = $row['definicion'];
      $ordenamiento = $row['ordenamiento'];
    ?>

    <tr>
      <td class='text-center'><?php echo $definicion;?></td>
      <td class='text-center'><?php echo $ordenamiento;?></td>

      <td class='text-center'>
        <button title="Eliminar Registro" type="button" name="button" class="btn btn-danger btn-sm glyphicon glyphicon-trash"
              onclick="eliminar('<?php echo $id_tmp; ?>','<?php echo $idCarrera; ?>')">
        </button>
    </tr>
    <?php
    }
    ?>

  </table>
<?php
}
?>
