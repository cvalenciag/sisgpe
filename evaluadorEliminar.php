<?php
	require_once 'connect.php';
	$conn->query("update evaluador set estado='$_REQUEST[estado]' WHERE `idEvaluador` = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	echo '
				<script type = "text/javascript">
					window.location = "evaluador.php";
				</script>
			';