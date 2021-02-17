<?php
	require_once 'connect.php';
	$conn->query("update alumno set estado='$_REQUEST[estado]' WHERE `idAlumno` = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	echo '
				<script type = "text/javascript">
					window.location = "alumno.php";
				</script>
			';