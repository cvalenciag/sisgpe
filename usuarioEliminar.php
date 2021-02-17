<?php
	require_once 'connect.php';
	$conn->query("update usuario set estado='$_REQUEST[estado]' WHERE `idUsuario` = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	echo '
				<script type = "text/javascript">
					window.location = "usuario.php";
				</script>
			';