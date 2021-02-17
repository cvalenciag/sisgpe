<?php
require_once '../valid.php';

$session_id= $_SESSION['session_id'];
$idCarrera = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$idMalla = (isset($_REQUEST['idMalla']) && !empty($_REQUEST['idMalla']))?$_REQUEST['idMalla']:'';
$fAprobacion = (isset($_REQUEST['fAprobacion']) && !empty($_REQUEST['fAprobacion']))?$_REQUEST['fAprobacion']:'';
$idCurso = (isset($_REQUEST['idCurso']) && !empty($_REQUEST['idCurso']))?$_REQUEST['idCurso']:'';
$idTemp = (isset($_REQUEST['id']) && !empty($_REQUEST['id']))?$_REQUEST['id']:'';

if ($idTemp!='')//codigo elimina un curso del array tabla temp
{
    // $id_tmp=intval($idTemp);
    $delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$idTemp."'");
}


if (isset($_POST['elegido']))//codigo que al seleccionar el combo de facultad, muestra las opciones de carrera
{
  $elegido = $_POST['elegido'];
    $qborrow = $conn->query("SELECT idCarrera,descripcion FROM carrera where estado=1 and idFacultad='$elegido' ORDER BY descripcion") or die(mysqli_error($conn));
    while($fborrow = $qborrow->fetch_array()){
        echo "<option value = '". $fborrow['idCarrera'] ."'>". $fborrow['descripcion'] . "</option>";
        }
}


if (isset($_POST['elegido8']))//fechaMalla
{
  $elegido8 = $_POST['elegido8'];
    echo "habla " . $elegido8;
    $qborrow = $conn->query("SELECT fAprobacion FROM malla where estado=1 and eliminado=0 and idCarrera='$elegido8'") or die(mysqli_error($conn));
    while($fborrow = $qborrow->fetch_array()){
        echo "<option value = '". $fborrow['fAprobacion'] ."'>". $fborrow['fAprobacion'] . "</option>";
        }
}

if (isset($_POST['elegido9']))//fechaPerfil
{
  $elegido9 = $_POST['elegido9'];
    $qborrow = $conn->query("SELECT cc.fAprobacion from carrera_competencia cc INNER JOIN carrera_og cog ON cc.fAprobacion=cog.fAprobacion INNER JOIN og_oe oge ONcog.fAprobacion=oge.fAprobacion where cc.idCarrera='$elegido9'") or die(mysqli_error($conn));
    while($fborrow = $qborrow->fetch_array()){
        echo "<option value = '". $fborrow['fAprobacion'] ."'>". $fborrow['fAprobacion'] . "</option>";
        }
}


//document.getElementById("ciclo_"' + $idCurso + ').focus();

if ($idCarrera!='')  // codigo que inserta cursos seleccionados en la tabla temp
{

$ciclo = $_POST['ciclo'];
$obligatorio = $_POST['obligatorio'];
$aol = $_POST['aol'];
// $ciclo = (isset($_REQUEST['ciclo']) && !empty($_REQUEST['ciclo']))?$_REQUEST['ciclo']:'';
// $obligatorio = (isset($_REQUEST['obligatorio']) && !empty($_REQUEST['obligatorio']))?$_REQUEST['obligatorio']:'';
// $aol = (isset($_REQUEST['aol']) && !empty($_REQUEST['aol']))?$_REQUEST['aol']:'';

if ($idCarrera!='' && $idCurso!='')  //
{

    $sql1=$conn->query("SELECT * from tmp where idCurso='$idCurso' and idCarrera='$idCarrera' and fAprobacion='$fAprobacion' and idSession='$session_id'");
    if ($sql1->num_rows==0)
    { // inicio if num_rows

        $sql2=$conn->query("SELECT * from detalle_malla where idCurso='$idCurso' and idCarrera='".$idCarrera."' and idMalla='$idMalla' and eliminado=0");
            if ($sql2->num_rows==0)
            { // inicio if num_rows

              $insert_tmp=mysqli_query($conn, "INSERT INTO tmp (idCurso,idCarrera,ciclo,fAprobacion,obligatorio,aol,idSession) VALUES ('$idCurso','$idCarrera','$ciclo','$fAprobacion','$obligatorio','$aol','$session_id')");
              echo '
                  <script type = "text/javascript">
                  alert("El curso fue agregado satisfactoriamente.");
                  </script>';
            }else {
               echo '
                <script type = "text/javascript">
                alert("El curso ya se encuentra registrado en la Base de datos.");
                </script>';
                }

     }
        else {
                echo '
                    <script type = "text/javascript">
                        alert("El curso ya fue agregado.");
                    </script>';
            } // cierra else


}

// luego muestra la tabla temp con los cursos seleccionados de acuerdo a la carrera elegida

	$sql=$conn->query("select * from curso, tmp where curso.idCurso=tmp.idCurso and tmp.fAprobacion = '$fAprobacion' and tmp.idCarrera='".$idCarrera."' and tmp.idSession='".$session_id."'");
        if ($sql->num_rows>0) {
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
	$id_tmp=$row["idTmp"];
	$nombreCurso=$row['nombreCurso'];
	$ciclo=$row['ciclo'];
	$obligatorio=$row['obligatorio'];
	$aol=$row['aol'];

		?>
		<tr>
			<td class='text-center'><?php echo $nombreCurso;?></td>
			<td class='text-center'><?php echo $ciclo;?></td>
			<td class='text-center'><?php echo ($obligatorio==1) ? "Obligatorio" : "Electivo"?></td>
			<td class='text-center'><?php echo ($aol==1) ? "Si" : "No"?></td>

			<td class='text-center'>
        <button type="button" name="button" class="btn btn-danger btn-sm glyphicon glyphicon-trash" onclick="eliminar('<?php echo $id_tmp; ?>','<?php echo $idCarrera; ?>')">
        </button>
        <!-- <a href="#" onclick="eliminar('<php echo $id_tmp; ?>','<php echo $idCarrera; ?>')"> -->
        <!-- <i class="btn btn-danger glyphicon glyphicon-trash"></i></a> -->
      </td>
		</tr>
		<?php
	}
        ?>
        </table>

        <?php
    }

}
?>
