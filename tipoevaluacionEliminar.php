<?php
	require_once 'connect.php';
	$conn->query("update tipo_evaluacion set estado='$_REQUEST[estado]' WHERE `idTipoEval` = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	echo '
				<script type = "text/javascript">
					window.location = "tipoevaluacion.php";
				</script>
			';