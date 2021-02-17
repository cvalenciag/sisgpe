<?php
	require_once 'connect.php';
	session_start();
	$session_id   = $_SESSION['session_id'];

 
	$estado	= (isset($_REQUEST['estado']) && !empty($_REQUEST['estado']))?$_REQUEST['estado']:'';
	$admin_id	= (isset($_REQUEST['admin_id']) && !empty($_REQUEST['admin_id']))?$_REQUEST['admin_id']:'';

	$conn->query("UPDATE grupoAlumno SET estado='$estado' WHERE idGrupoAl='$admin_id'") or die(mysqli_error($conn));

	if ($conn->affected_rows==1){
		$conn->query("UPDATE detalle_grupoAlumno SET estado='$estado' WHERE idGrupoAl='$admin_id'") or die(mysqli_error($conn));
	}

	echo '<script type = "text/javascript">
					window.location = "grupoAlumno.php";
				</script>';



// ELIMINA ALUMNOS REGISTRADOS==================================================
$deleteAlumn = (isset($_REQUEST['delete']) && !empty($_REQUEST['delete']))?$_REQUEST['delete']:'';
if($deleteAlumn == 'd')
{
	// $idGrupoAl	= $_POST['idGpoAl'];
	$idTmp			= $_POST['idTempo'];
	$idAlumno		= $_POST['idAlumno'];

	// $deleteRegistro = mysqli_query($conn, "DELETE FROM detalle_grupoAlumno WHERE idGrupoAl='$idGrupoAl' AND idalumno='$idAlumno'");
	$qryDelTempo = $conn->query("SELECT * FROM tmp WHERE idTmp='$idTmp'");
	if($qryDelTempo->num_rows==1){
		// $deleteRegistro = mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='$idTmp' AND idAlumno='$idAlumno'");
		$delRegTempo = mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='$idTmp'");

		echo '<script type = "text/javascript">
						alert("El registro se eliminó correctamente.");
					</script>';
	}


?>

<table class="table table-bordered" style="width:100%;">
	<thead>
		<tr class="alert-info">
			<th class="text-center">Nombre</th>
			<th class="text-center">Apellido</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		// $qryAlumnos = $conn->query("SELECT dga.idGrupoAl, dga.idalumno, nomAlumno, apeAlumno FROM detalle_grupoAlumno dga LEFT JOIN alumno a ON(a.idAlumno=dga.idalumno) WHERE dga.idGrupoAl='$idGrupoAl' AND dga.estado=1") or die(mysqli_error($conn));

		$qryAlumnos = $conn->query("SELECT t.idTmp, t.idAlumno, nomAlumno, apeAlumno FROM tmp t LEFT JOIN alumno a ON(a.idAlumno=t.idAlumno) WHERE t.idSession='$session_id'") or die(mysqli_error($conn));

		foreach ($qryAlumnos as $alumnos)
		{
			$idTmp = $alumnos['idTmp'];
		?>
			<tr>
				<td><?php echo $alumnos['nomAlumno'] ?></td>
				<td><?php echo $alumnos['apeAlumno'] ?></td>
				<td class="text-center">
					<button type="button" name="button" class="btn btn-danger btn-sm" id="<?php echo $alumnos['idAlumno'] ?>" title="Elimina Alumno" onclick="deleteAlumno(<?php echo $alumnos['idalumno'] ?>,<?php echo $idTmp ?> );">
						<span class="glyphicon glyphicon-trash"></span>
					</button>

				</td>
			</tr>
		<?php
		}
		?>
	</tbody>
</table>

<?php
}
?>


<!-- inicio para eliminar detalles al editar -->
<?php
$delDetalleAlu = (isset($_REQUEST['delDetalle']) && !empty($_REQUEST['delDetalle']))?$_REQUEST['delDetalle']:'';
if($delDetalleAlu == 'dd')
{
	$idGrupoAl	= $_POST['xIdGrupoAl'];
	$idAlumno		= $_POST['xIdAlumno'];

	$deleteRegistro = mysqli_query($conn, "DELETE FROM detalle_grupoAlumno WHERE idGrupoAl='$idGrupoAl' AND idalumno='$idAlumno'");

	echo '<script type = "text/javascript">
					alert("El registro se eliminó correctamente.");
				</script>';
?>

<table class="table table-bordered" style="width:100%;">
	<thead>
		<tr class="alert-info">
			<th class="text-center">Nombre</th>
			<th class="text-center">Apellido</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$qryAlumnos = $conn->query("SELECT dga.idGrupoAl, dga.idalumno, nomAlumno, apeAlumno FROM detalle_grupoAlumno dga LEFT JOIN alumno a ON(a.idAlumno=dga.idalumno) WHERE dga.idGrupoAl='$idGrupoAl'") or die(mysqli_error($conn));

		foreach ($qryAlumnos as $alumnos){
		?>
			<tr>
				<td><?php echo $alumnos['nomAlumno'] ?></td>
				<td><?php echo $alumnos['apeAlumno'] ?></td>
				<td class="text-center">
					<button type="button" name="button" class="btn btn-danger btn-sm" id="<?php echo $alumnos['idAlumno'] ?>" title="Elimina Alumno" onclick="deleteAlumno2(<?php echo $alumnos['idalumno'] ?>,<?php $alumnos['idGrupoAl'] ?> );">
						<span class="glyphicon glyphicon-trash"></span>
					</button>
				</td>
			</tr>
		<?php
		}
		?>
	</tbody>
</table>
<?php
}
?>

<!-- fin para eliminar detalles al editar -->



<script type="text/javascript">
	function deleteAlumno(idAlumno, idTmp){

		$.ajax({
			type: 'POST',
			url: 'grupoAlumnoEliminar.php',
			data: '&idTempo='+idTmp+'&idAlumno='+idAlumno+'&delete=d',

			beforeSend: function(objeto){
				$("#resultAlumnos").html("Mensaje: Cargando...");
			},

			success: function(datos){
				$("#resultAlumnos").html(datos);
			}

		}); //LLAVE AJAX
	}



	function deleteAlumno2(idAlumno, idGpoAl){

		$.ajax({
			type: 'POST',
			url: 'grupoAlumnoEliminar.php',
			data: '&xIdGrupoAl='+idGpoAl+'&xIdAlumno='+idAlumno+'&delDetalle=dd',

			beforeSend: function(objeto){
				$("#resultAlumnos").html("Mensaje: Cargando...");
			},

			success: function(datos){
				$("#resultAlumnos").html(datos);
			}

		}); //LLAVE AJAX
	}
</script>
