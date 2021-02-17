<?php
	require_once 'connect.php';
	$conn->query("update carrera set estado='$_REQUEST[estado]' WHERE `idCarrera` = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	echo '
				<script type = "text/javascript">
					window.location = "carrera.php";
				</script>
			';