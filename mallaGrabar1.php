<?php

require_once 'valid.php';
$session_id= $_SESSION['session_id'];

$idCarrera      = $_POST['idCarrera'];
$fAprobacion    = $_POST['fAprobacion'];
$fActualizacion = $_POST['fActualizacion'];
$estado         = $_POST['estado'];

$idCurso        = $_POST['idCurso'];
$ciclo          = $_POST['ciclo'];
$obligatorio    = $_POST['obligatorio'];
$aol            = $_POST['aol'];


//AGREGA LOS DETALLES EN LA BASE TEMPORAL
$sqlTmp = $conn->query("SELECT * FROM tmp where idCurso='$idCurso' and idCarrera='$idCarrera' and fAprobacion='$fAprobacion' and idSession='$session_id'");
if ($sqlTmp->num_rows==0)
{
  $insert = mysqli_query($conn, "INSERT INTO tmp (idCurso, ciclo, obligatorio, aol, idSession, idCarrera, fAprobacion) VALUES ('$idCurso','$ciclo','$obligatorio','$aol','$session_id','$idCarrera','$fAprobacion')");

  echo '<script type = "text/javascript">
        alert("El curso fue agregado satisfactoriamente.");
        </script>';
}else {
  echo '<script type = "text/javascript">
        alert("El curso ya se encuentra registrado en la base de datos.");
        </script>';
}



// MUESTRA LOS DATOS DE LA TABLA TEMPORAL ==================
$sql = $conn->query("SELECT * FROM curso c, tmp t WHERE c.idCurso=t.idCurso AND t.fAprobacion='".$fAprobacion."' AND  t.idCarrera='".$idCarrera."' and t.idSession='".$session_id."'");

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
        <td class='text-center'><?php echo $nombreCurso;?></td>
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
