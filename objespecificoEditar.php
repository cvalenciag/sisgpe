<?php
	require_once 'connect.php';
	if(ISSET($_POST['edit_user'])){	
			$conn->query("UPDATE objespecifico SET definicion = '$_POST[definicion]', estado = '$_POST[estado]' WHERE idObjespecifico = '$_REQUEST[admin_id]'") or die (mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente");
					window.location = "objespecifico.php";
				</script>
			';
	}	