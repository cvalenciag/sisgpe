<?php
	require_once 'connect.php';
	if(ISSET($_POST['edit_user'])){	

			$conn->query("UPDATE nivel SET estado='$_POST[estado]',descripcion='$_POST[descripcion]' WHERE idNivel = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente");
					window.location = "nivel.php";
				</script>
			';
	}