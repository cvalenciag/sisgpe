<?php
require_once '../valid.php';
$session_id= $_SESSION['session_id'];

$idCarrera = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$idCompetencia = (isset($_REQUEST['idCompetencia']) && !empty($_REQUEST['idCompetencia']))?$_REQUEST['idCompetencia']:'';
$idCarreraOg = (isset($_REQUEST['idCarreraOg']) && !empty($_REQUEST['idCarreraOg']))?$_REQUEST['idCarreraOg']:'';
$ordenamiento = (isset($_REQUEST['ordenamiento']) && !empty($_REQUEST['ordenamiento']))?$_REQUEST['ordenamiento']:'';
$idObjgeneral = (isset($_REQUEST['idObjgeneral']) && !empty($_REQUEST['idObjgeneral']))?$_REQUEST['idObjgeneral']:'';
$fAprobacion = (isset($_REQUEST['fAprobacion']) && !empty($_REQUEST['fAprobacion']))?$_REQUEST['fAprobacion']:'';
$idTemp = (isset($_REQUEST['id']) && !empty($_REQUEST['id']))?$_REQUEST['id']:'';
/*if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['ordenamiento'])){$ordenamiento=$_POST['ordenamiento'];}*/
// if ($idTemp!='')//codigo elimina un curso del array tabla temp
// {
//     $id_tmp=intval($idTemp);
//     $delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$id_tmp."'");
// }
/*if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_GET['id']);
$delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$id_tmp."'");
}*/

/*if (!empty($id) and !empty($ordenamiento))
{
$insert_tmp=mysqli_query($conn, "INSERT INTO tmp (idObjgeneral,ordenamiento,idSession) VALUES ('$id','$ordenamiento','$session_id')");

}

if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_GET['id']);
$delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$id_tmp."'");
}*/

if (isset($_POST['elegido']))//selecciona combo hijo
{
  $elegido = $_POST['elegido'];
  $qborrow = $conn->query("SELECT idCarrera,descripcion FROM carrera where estado=1 and idFacultad='$elegido' ORDER BY descripcion") or die(mysqli_error($conn));

  while($fborrow = $qborrow->fetch_array())
  {
    echo "<option value = '". $fborrow['idCarrera'] ."'>". $fborrow['descripcion'] . "</option>";
  }
}


if (isset($_POST['elegido2']))//selecciona combo hijo
{
  $elegido2 = $_POST['elegido2'];

  if ($elegido2!='0') {
    $qborrow = $conn->query("SELECT idCompetencia,descripcion FROM competencia where estado=1 and idTipo='$elegido2' ORDER BY descripcion") or die(mysqli_error($conn));
  }else {
    $qborrow1 = $conn->query("SELECT idCompetencia,descripcion FROM competencia where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
  }

?>

<!-- <option value="" >Seleccione una opción</option> -->

<?php
if ($elegido2 == '0') {
  echo "<option value=''>Todas las competencias</option>";

  while($fborrow1 = $qborrow1->fetch_array()){

    echo "<option value = '". $fborrow1['idCompetencia'] ."'>". $fborrow1['descripcion'] . "</option>";

  }


}else {
  while($fborrow = $qborrow->fetch_array()){

    echo "<option value = '". $fborrow['idCompetencia'] ."'>". $fborrow['descripcion'] . "</option>";

  }
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



if ($idCarrera!='' && $idObjgeneral!='')  //
{
    /*echo "ordenamiento: " . $ordenamiento;
	Verificar si el objetivo general existe en la tabla temporal de acuerdo a la carrera y fecha de aprobación*/
    $sql1=$conn->query("select * from tmp where idObjgeneral='$idObjgeneral' and idCarrera='$idCarrera' and fAprobacion='$fAprobacion' and idSession='$session_id'");
    if ($sql1->num_rows==0)
    { // inicio if num_rows
		/* Verificar si el objetivo general existe en la tabla detalle_carrera_og de acuerdo a la carrera*/
        $sql2=$conn->query("select * from detalle_carrera_og where idObjgeneral='$idObjgeneral' and idCarrera='".$idCarrera."' and idCarreraOg='$idCarreraOg' and eliminado=0");
            if ($sql2->num_rows==0)
            { // inicio if num_rows
			
			//Verificar si el ordenamiento para el objetivo general y competencia existen en la temporal
            $sql3=$conn->query("select * from tmp where idCarrera='$idCarrera' and idCompetencia = '$idCompetencia' and ordenamiento='$ordenamiento' and idSession='$session_id'");
            /*echo "cantidad: " . $sql3->num_rows;*/
              if ($sql3->num_rows==0)
            { // inicio if num_rows
            $insert_tmp=mysqli_query($conn, "INSERT INTO tmp (idObjgeneral,idCarrera,idCompetencia,fAprobacion,ordenamiento,idSession) VALUES ('$idObjgeneral','$idCarrera','$idCompetencia','$fAprobacion','$ordenamiento','$session_id')");
           /* }
            else {*/
               echo '
                <script type = "text/javascript">
                alert("El objetivo general fue agregado satisfactoriamente.");
                </script>';
                 }


        else {
                                    echo '
                                    <script type = "text/javascript">
                                      alert("El número de orden ya existe. Favor de cambiar el número.");
                                    </script>';

                                         echo '<script type = "text/javascript">
                                        $("#ordenamiento_' . $idObjgeneral . '").val("");
                                        </script>
                                        ';
                                 }

     }
        else {
                echo '
                    <script type = "text/javascript">
                        alert("El objetivo general ya se encuentra registrado en la base de datos.");
                    </script>';
             }

     }
        else {
                echo '
                    <script type = "text/javascript">
                        alert("El objetivo general ya fue agregado.");
                    </script>';
            } // cierra else


}



/*if (isset($_POST['id']) and isset($_POST['ordenamiento']) and isset($_POST['idCarrera']))  // codigo que inserta cursos seleccionados en la tabla temp
{

 $idCarrera = $_POST['idCarrera'];
 $idCarreraOg = $_POST['idCarreraOg'];
 $id = $_POST['id'];
 $ordenamiento = $_POST['ordenamiento'];

$sql2=$conn->query("select * from detalle_carrera_og where idObjgeneral='$id' and idCarrera='".$idCarrera."' and idCarreraOg='$idCarreraOg' and eliminado=0");
				if ($sql2->num_rows==0)
				{ // inicio if num_rows
$insert_tmp=mysqli_query($conn, "INSERT INTO tmp (idObjgeneral,idCarrera,ordenamiento,idSession) VALUES ('$id','$idCarrera','$ordenamiento','$session_id')");

				} else {
						echo '
				<script type = "text/javascript">
					alert("Registro ya existe!!!");
				</script>';
					} */

// luego muestra la tabla temp con los cursos seleccionados de acuerdo a la carrera elegida

	$sql=$conn->query("select * from objgeneral, tmp where objgeneral.idObjgeneral=tmp.idObjgeneral and tmp.idCarrera='".$idCarrera."' and tmp.fAprobacion = '$fAprobacion' and tmp.idSession='".$session_id."'");
        if ($sql->num_rows>0) {



?>

<table class="table table-bordered" style="width:100%;">
  <tr class = "alert-info">
    <th class='text-center'>Objetivo general</th>
	<th class='text-center'>Competencia</th>
    <th class='text-center'>Ordenamiento</th>
	  <th class='text-center'>Opciones</th>
</tr>
<?php
	/*$sql=mysqli_query($conn, "select * from objgeneral, tmp where objgeneral.idObjgeneral=tmp.idObjgeneral and tmp.idSession='".$session_id."'");*/
	while ($row=mysqli_fetch_array($sql))
	{
	$id_tmp=$row["idTmp"];
	$definicion=$row['definicion'];
	$ordenamiento=$row['ordenamiento'];
	$result = $conn->query("SELECT descripcion FROM competencia where idCompetencia = '" . $idCompetencia . "'");
	$fila = $result->fetch_assoc();
		?>
		<tr>
			<td class='text-center'><?php echo $definicion;?></td>
			<td class='text-center'><?php echo $fila["descripcion"];?></td>
			<td class='text-center'><?php echo $ordenamiento;?></td>

			<td class='text-center'>
        <button title="Eliminar Registro" type="button" name="button" class="btn btn-danger btn-sm glyphicon glyphicon-trash"
                onclick="eliminar('<?php echo $id_tmp; ?>','<?php echo $idCarrera; ?>')">
        </button>
        <!-- <a href="#" ><i ></i></a></td> -->
		</tr>
		<?php
	}

?>

</table>
<?php
    }

}
?>
