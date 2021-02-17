<?php
	require_once 'connect.php';
	if(ISSET($_POST['edit_user'])){	
			$conn->query("UPDATE curso SET nombreCurso = '$_POST[nombreCurso]', tipoCurso = '$_POST[tipoCurso]', idDepartamento = '$_POST[idDepartamento]', cantHorasPractica = '$_POST[cantHorasPractica]', cantHorasTeorica = '$_POST[cantHorasTeorica]', credito = '$_POST[credito]', estado = '$_POST[estado]' WHERE idCurso = '$_REQUEST[admin_id]'") or die (mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente");
					window.location = "curso.php";
				</script>
			';
	}