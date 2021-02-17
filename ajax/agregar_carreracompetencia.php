<?php
require_once '../valid.php';
$session_id= $_SESSION['session_id'];

$idCarrera = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$ordenamiento = (isset($_REQUEST['ordenamiento']) && !empty($_REQUEST['ordenamiento']))?$_REQUEST['ordenamiento']:'';
$idCarreraCompetencia = (isset($_REQUEST['idCarreraCompetencia']) && !empty($_REQUEST['idCarreraCompetencia']))?$_REQUEST['idCarreraCompetencia']:'';
$idCompetencia = (isset($_REQUEST['idCompetencia']) && !empty($_REQUEST['idCompetencia']))?$_REQUEST['idCompetencia']:'';
$fAprobacion = (isset($_REQUEST['fAprobacion']) && !empty($_REQUEST['fAprobacion']))?$_REQUEST['fAprobacion']:'';   //CAMBIO
$idTemp = (isset($_REQUEST['id']) && !empty($_REQUEST['id']))?$_REQUEST['id']:'';

// if ($idTemp!='')//codigo elimina un curso del array tabla temp
// {
//     $id_tmp=intval($idTemp);
//     $delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$id_tmp."'");
// }

/*$session_id= $_SESSION['session_id'];*/
/*if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['ordenamiento'])){$ordenamiento=$_POST['ordenamiento'];}*/

/*if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_GET['id']);
$delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$id_tmp."'");
}*/

	/* Connect To Database*/
	//include 'connect.php';

/*if (!empty($id) and !empty($ordenamiento))
{
$insert_tmp=mysqli_query($conn, "INSERT INTO tmp (idCompetencia,ordenamiento,idSession) VALUES ('$id','$ordenamiento','$session_id')");

}

if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_GET['id']);
$delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$id_tmp."'");
}*/

if (isset($_POST['elegido']))//codigo elimina un elemento del array
{
  $elegido = $_POST['elegido'];
$qborrow = $conn->query("SELECT idCarrera,descripcion FROM carrera where estado=1 and idFacultad='$elegido' ORDER BY descripcion") or die(mysqli_error($conn));
while($fborrow = $qborrow->fetch_array()){

    echo "<option value = '". $fborrow['idCarrera'] ."'>". $fborrow['descripcion'] . "</option>";

}

/*if (isset($_POST['elegido1']))//codigo elimina un elemento del array
{
  $elegido1 = $_POST['elegido1'];
$qborrow = $conn->query("SELECT idObjgeneral,definicion FROM objgeneral where estado=1 and idCompetencia='$elegido1' ORDER BY definicion") or die(mysqli_error($conn));
while($fborrow = $qborrow->fetch_array()){

    echo "<option value = '". $fborrow['idObjgeneral'] ."'>". $fborrow['definicion'] . "</option>";
  }*/
    }


    if ($idCarrera!='')  // codigo que inserta cursos seleccionados en la tabla temp
{



if ($idCarrera!='' && $idCompetencia!='')  //
{
    /*echo "ordenamiento: " . $ordenamiento;*/
    $sql1=$conn->query("select * from tmp where idCompetencia='$idCompetencia' and idCarrera='$idCarrera' and fAprobacion='$fAprobacion' and idSession='$session_id'");
    if ($sql1->num_rows==0)
    { // inicio if num_rows

        $sql2=$conn->query("select * from detalle_carrera_competencia where idCompetencia='$idCompetencia' and idCarrera='".$idCarrera."' and idCarreraCompetencia='$idCarreraCompetencia' and eliminado=0");
            if ($sql2->num_rows==0)
            { // inicio if num_rows

 $sql3=$conn->query("select * from tmp where idCarrera='$idCarrera' and ordenamiento='$ordenamiento' and idSession='$session_id'");
          /*  echo "cantidad: " . $sql3->num_rows;*/
              if ($sql3->num_rows==0)
            { // inicio if num_rows

            $insert_tmp=mysqli_query($conn, "INSERT INTO tmp (idCompetencia,idCarrera,fAprobacion,ordenamiento,idSession) VALUES ('$idCompetencia','$idCarrera','$fAprobacion','$ordenamiento','$session_id')");
          /*  }
            else {*/
               echo '
                <script type = "text/javascript">
                alert("La competencia fue agregada satisfactoriamente.");
                </script>';
                }
          else {
                                    echo '
                                        <script type = "text/javascript">
                                          alert("El numero de orden ya existe. Por favor cambie de número");
                                        </script>';

                                         echo '<script type = "text/javascript">
                                        $("#ordenamiento_' . $idCompetencia . '").val("");

                                        </script>
                                        ';
                                 }

       }
        else {
                echo '
                    <script type = "text/javascript">
                        alert("La competencia ya se encuentra registrada en la base de datos.");
                    </script>';
             }

     }
        else {
                echo '
                    <script type = "text/javascript">
                        alert("La competencia ya fue agregada.");
                    </script>';
            } // cierra else


}


/*if (isset($_POST['id']) and isset($_POST['ordenamiento']) and isset($_POST['idCarrera']))  // codigo que inserta cursos seleccionados en la tabla temp
{

 $idCarrera = $_POST['idCarrera'];
 $idCarreraCompetencia = $_POST['idCarreraCompetencia'];
 $id = $_POST['id'];
 $ordenamiento = $_POST['ordenamiento'];

$sql2=$conn->query("select * from detalle_carrera_competencia where idCompetencia='$id' and idCarrera='".$idCarrera."' and idCarreraCompetencia='$idCarreraCompetencia' and eliminado=0");
				if ($sql2->num_rows==0)
				{ // inicio if num_rows
$insert_tmp=mysqli_query($conn, "INSERT INTO tmp (idCompetencia,idCarrera,ordenamiento,idSession) VALUES ('$id','$idCarrera','$ordenamiento','$session_id')");

				} else {
						echo '
				<script type = "text/javascript">
					alert("Registro ya existe!!!");
				</script>';
					} */

// luego muestra la tabla temp con los cursos seleccionados de acuerdo a la carrera elegida

	$sql=$conn->query("select * from competencia, tmp where competencia.idCompetencia=tmp.idCompetencia and tmp.fAprobacion = '$fAprobacion' and tmp.idCarrera='".$idCarrera."' and tmp.idSession='".$session_id."'");
        if ($sql->num_rows>0) {



?>
<table class="table table-bordered" style="width:100%;">
<tr class="alert-info">
	<th class='text-center'>Competencia</th>
	<th class='text-center'>Ordenamiento</th>
	<th></th>
</tr>
<?php
	/*$sql=mysqli_query($conn, "select * from competencia, tmp where competencia.idCompetencia=tmp.idCompetencia and tmp.idSession='".$session_id."'");*/
	while ($row=mysqli_fetch_array($sql))
	{
	$id_tmp=$row["idTmp"];
	$descripcion=$row['descripcion'];
	$ordenamiento=$row['ordenamiento'];
		?>
		<tr>
			<td class='text-center'><?php echo $descripcion;?></td>
			<td class='text-center'><?php echo $ordenamiento;?></td>

			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp; ?>')"><i class="btn btn-sm btn-danger glyphicon glyphicon-trash"></i></a></td>
		</tr>
		<?php
	}


?>

</table>
<?php
    }

}
?>
