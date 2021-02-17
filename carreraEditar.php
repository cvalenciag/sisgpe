<?php
	require_once 'connect.php';
	if(ISSET($_POST['edit_user'])){	
			$conn->query("UPDATE carrera SET descripcion = '$_POST[descripcion]', idFacultad = '$_POST[idFacultad]', estado = '$_POST[estado]' WHERE idCarrera = '$_REQUEST[idCarrera]'") or die(mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente");
					window.location = "carrera.php";
				</script>
			';
            
	}	