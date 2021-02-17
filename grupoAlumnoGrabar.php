<?php
	// require_once 'connect.php';
	require_once 'valid.php';
	$session_id= $_SESSION['session_id'];

	$addGeneral = (isset($_REQUEST['add']) && !empty($_REQUEST['add']))?$_REQUEST['add']:'';
	if($addGeneral == 'a')
	{
		$qryTemp = $conn->query("SELECT * FROM tmp WHERE idSession='$session_id'");

		if($qryTemp->num_rows>0)
		{
			$descripcion	= $_POST['descGrupo'];
			$semestre 		= $_POST['idSemestre'];
			$idCurso 			= $_POST['idCurso'];
			$nameFile 		= $_POST['fileName'];

			$q_admin = $conn->query("SELECT * FROM grupoAlumno WHERE descripcion='$descripcion'") or die(mysqli_error($conn));

			if($q_admin->num_rows==1)
			{
				echo '<script type = "text/javascript">
								alert("El nombre del grupo ya existe, favor de verificar.");
							</script>';
			}else{

				$fname = $nameFile;
	      $chk_ext = explode(".", $fname);

	      if(strtolower(end($chk_ext)) == "pdf" || strtolower(end($chk_ext)) == "docx" || strtolower(end($chk_ext)) == "doc" || $nameFile=='')
	      {
					$filename = $nameFile;
					$filename = addslashes($filename);

					$conn->query("INSERT INTO grupoAlumno (descripcion, semestre, idCurso, infAdjunto, estado) VALUES('$descripcion', '$semestre', '$idCurso', '$filename', 1)") or die(mysqli_error($conn));

					echo '<script type = "text/javascript">
									alert("El registro se agregó correctamente.");
									window.location = "grupoAlumno.php";
								</script>';
				}
				// else {
				//
				// 	echo '<script type = "text/javascript">
				// 					alert("El archivo no contiene un formato válido.");
				// 				</script>';
				// }
			} //LLAVE PARA VALIDACION DE ARCHIVO


			if($conn->affected_rows == 1)
			{
				$idGrupoAl = $conn->insert_id;

				foreach ($qryTemp as $temp)
				{
					$idTmp 		= $temp['idTmp'];
					$idAlumno	= $temp['idAlumno'];

					$conn->query("INSERT INTO detalle_grupoAlumno (idGrupoAl, idalumno, estado) VALUES ('$idGrupoAl', '$idAlumno', 1)") or die (mysqli_error($conn));

					if($conn->affected_rows==1){
        		$deleteTempo = mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='$idTmp' AND idSession='$session_id'");
      		}
				}
			}

		//LLAVE QUE VALIDA SI EXISTEN REGISTROS EN TEMPORAL
		} else {
			echo "<input type='hidden' id='idResult' value='2'/>";
		}

	} //FIN LLAVE PARA AGREGAR LA CABECERA NUEVO REGISTRO


// ===============================================================================================================
//AGREGA LOS ALUMNOS A LA TABLA TEMPORAL
$idDetalle = (isset($_REQUEST['detalle']) && !empty($_REQUEST['detalle']))?$_REQUEST['detalle']:'';
if($idDetalle == 'd')
{
	// $idGrupoAl	= ($_POST['idGrupoAl'] != 0 ? $_POST['idGrupoAl'] : 1);
	$idAlumno 	= $_POST['idalumno'];

	$qryAlumTmp = $conn->query("SELECT * FROM tmp WHERE idAlumno='$idAlumno' AND idSession='$session_id'") or die(mysqli_error($conn));

	if($qryAlumTmp->num_rows==0){
		// $conn->query("INSERT INTO tmp (idGrupoAl, idalumno, estado)
		$conn->query("INSERT INTO tmp (idAlumno, idSession) VALUES('$idAlumno', '$session_id')") or die(mysqli_error($conn));

		echo '<script type = "text/javascript">
						alert("El registro se agregó correctamente.");
					</script>';

	}else {
		echo '<script type = "text/javascript">
						alert("El alumno ya se encuentra registrado.");
					</script>';
	}


?>

<table class="table table-bordered" style="width:100%;" >
	<thead>
		<tr class="alert-info">
			<th class="text-center">Nombre</th>
			<th class="text-center">Apellido</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		// $idGrupoAl	= ($_POST['idGrupoAl'] != 0 ? $_POST['idGrupoAl'] : 1);

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
					<button type="button" name="button" class="btn btn-danger btn-sm" id="<?php echo $alumnos['idAlumno'] ?>" title="Elimina Alumno" onclick="deleteAlumno(<?php echo $alumnos['idAlumno'] ?>,<?php echo $idTmp ?> );">
						<span class="glyphicon glyphicon-trash"></span>
					</button>

					<!-- <button type="button" name="button" class="btn btn-danger btn-sm" id="<?php echo $alumnos['idalumno'] ?>" title="Elimina Alumno" onclick="deleteAlumno(<?php echo $alumnos['idalumno'] ?>,<?php echo $idGrupoAl ?> );">
						<span class="glyphicon glyphicon-trash"></span>
					</button> -->


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
<!-- FIN AGREGAR REGISTRO DE ALUMNOS A TEMPORAL -->


<!-- inicio de registro de datos en tabla detalle -->
<?php

$idDetalleEditar = (isset($_REQUEST['detalleEdit']) && !empty($_REQUEST['detalleEdit']))?$_REQUEST['detalleEdit']:'';
if($idDetalleEditar == 'dA')
{
	$idGrupoAl 	= $_POST['xIdGpoAluE'];
	$idAlumno 	= $_POST['xIdAlumno'];

	$qryAlumTmp = $conn->query("SELECT * FROM detalle_grupoAlumno WHERE idGrupoAl='$idGrupoAl' AND idAlumno='$idAlumno'") or die(mysqli_error($conn));

	if($qryAlumTmp->num_rows==0){
		$conn->query("INSERT INTO detalle_grupoAlumno (idGrupoAl, idAlumno, estado) VALUES('$idGrupoAl', '$idAlumno', 1)") or die(mysqli_error($conn));

		echo '<script type = "text/javascript">
						alert("El registro se agregó correctamente.");
					</script>';

	}else {
		echo '<script type = "text/javascript">
						alert("El alumno ya se encuentra registrado.");
					</script>';
	}
?>

<table class="table table-bordered" style="width:100%;" >
	<thead>
		<tr class="alert-info">
			<th class="text-center">Nombre</th>
			<th class="text-center">Apellido</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$qryAlumnos = $conn->query("SELECT dga.idGrupoAl, dga.idalumno, nomAlumno, apeAlumno FROM detalle_grupoAlumno dga LEFT JOIN alumno a ON(a.idAlumno=dga.idalumno) WHERE dga.idGrupoAl='$idGrupoAl' AND dga.estado=1") or die(mysqli_error($conn));

		foreach ($qryAlumnos as $alumnos){
		?>
			<tr>
				<td><?php echo $alumnos['nomAlumno'] ?></td>
				<td><?php echo $alumnos['apeAlumno'] ?></td>
				<td class="text-center">
					<button type="button" name="button" class="btn btn-danger btn-sm" id="<?php echo $alumnos['idalumno'] ?>" title="Elimina Alumno" onclick="deleteAlumno2(<?php echo $alumnos['idalumno'] ?>,<?php echo $idGrupoAl ?> );">
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
<!-- fin de registro de datos en tabla detalle -->


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
