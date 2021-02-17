<?php
	require_once 'connect.php';
	if(ISSET($_POST['edit_user'])){	
			$conn->query("UPDATE objgeneral SET definicion = '$_POST[definicion]', idCompetencia = '$_POST[idCompetencia]',estado = '$_POST[estado]' WHERE idObjgeneral = '$_REQUEST[admin_id]'") or die (mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente");
					window.location = "objgeneral.php";
				</script>
			';
	}	