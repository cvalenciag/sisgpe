<?php
	require_once 'connect.php';
	// if(ISSET($_POST['edit_user'])){
	//
	// 		$conn->query("UPDATE grupoAlumno SET estado='$_POST[estado]',descripcion='$_POST[descripcion]' WHERE idGrupoAl = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	// 		echo '
	// 			<script type = "text/javascript">
	// 				alert("Registro actualizado correctamente");
	// 				window.location = "grupoAlumno.php";
	// 			</script>
	// 		';
	// }
	$idGrupoAl 		= $_POST['idGpoAl'];
	$descripcion	= $_POST['descGrupo'];
	$semestre 		= $_POST['idSemestre'];
	$idCurso 			= $_POST['idCurso'];

	$qryExistente = $conn->query("SELECT * FROM grupoAlumno WHERE idGrupoAl='$idGrupoAl' AND descripcion='$descripcion' AND semestre='$semestre' AND idCurso='$idCurso'") or die(mysqli_error($conn));

	if($qryExistente->num_rows == 1)
	{
		echo '<script type = "text/javascript">
						window.location = "grupoAlumno.php";
					</script>';
	}else {

		$conn->query("UPDATE grupoAlumno SET descripcion='$descripcion', semestre='$semestre', idCurso='$idCurso' WHERE idGrupoAl='$idGrupoAl'") or die(mysqli_error($conn));

		echo '<script type = "text/javascript">
						alert("El registro se actualizó correctamente.");
						window.location = "grupoAlumno.php";
					</script>';

	}
