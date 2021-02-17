<?php
	require_once 'connect.php';
	if(ISSET($_POST['edit_user'])){
			$conn->query("UPDATE alumno SET nomAlumno = '$_POST[nombre]',apeAlumno = '$_POST[apellido]', idCarrera = '$_POST[idCarrera]', estado = '$_POST[estado]' WHERE idAlumno = '$_REQUEST[idAlumno]'") or die(mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente.");
					window.location = "alumno.php";
				</script>
			';

	}
