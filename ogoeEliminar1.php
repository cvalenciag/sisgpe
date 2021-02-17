<?php
require_once 'valid.php';
$session_id= $_SESSION['session_id'];
$idTmp        = $_POST["id"];
$fAprobacion  = $_POST["fAprobacion"];
// $idObjgeneral  = $_REQUEST["idObjgeneral"];


$sqlDelete = $conn->query("SELECT * FROM tmp WHERE idTmp='$idTmp'");
if($sqlDelete->num_rows==1){

  $deleteTmp = mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$idTmp."'");
}


// MUESTRA LOS DATOS DE LA TABLA TEMPORAL ==================
$sql=$conn->query("SELECT  * FROM objespecifico o, tmp t WHERE o.idObjespecifico=t.idObjespecifico AND t.fAprobacion = '$fAprobacion' AND t.idSession='".$session_id."'");

if ($sql->num_rows>0)
{
?>
	<table class="table table-bordered" style="width:100%;">
		<tr class='alert-info'>
			<th class='text-center'>Objetivo especifico</th>
			<th class='text-center'>Ordenamiento</th>
			<th></th>
	</tr>
	<?php

	while ($row=mysqli_fetch_array($sql))
	{
		$id_tmp=$row["idTmp"];
		$definicion=$row['definicion'];
		$ordenamiento=$row['ordenamiento'];
	?>

		<tr>
			<td class='text-center'><?php echo $definicion;?></td>
			<td class='text-center'><?php echo $ordenamiento;?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp; ?>')">
				<i class="btn btn-danger btn-sm glyphicon glyphicon-trash"></i></a>
			</td>
		</tr>
	<?php
	}
	?>

	</table>

<?php

}
?>
