<?php
	require_once 'connect.php';
	if(ISSET($_POST['edit_user'])){	
			$conn->query("UPDATE subcriterio SET descripcion = '$_POST[descripcion]', idCriterio = '$_POST[idCriterio]', estado = '$_POST[estado]' WHERE idSubcriterio = '$_REQUEST[idSubcriterio]'") or die(mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente");
					window.location = "subcriterio.php";
				</script>
			';
            
	}	