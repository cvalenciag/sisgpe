<?php
	require_once 'connect.php';
	$conn->query("update departamento set estado='$_REQUEST[estado]' WHERE `idDepartamento` = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	echo '
				<script type = "text/javascript">
					window.location = "departamento.php";
				</script>
			';