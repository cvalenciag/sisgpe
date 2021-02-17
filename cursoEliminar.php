<?php
	require_once 'connect.php';
	$conn->query("update curso set estado='$_REQUEST[estado]' WHERE `idCurso` = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	echo '
				<script type = "text/javascript">
					window.location = "curso.php";
				</script>
			';