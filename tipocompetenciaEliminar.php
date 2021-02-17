<?php
	require_once 'connect.php';
	$conn->query("update tipocompetencia set estado='$_REQUEST[estado]' WHERE `idTipo` = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	echo '
				<script type = "text/javascript">
					window.location = "tipocompetencia.php";
				</script>
			';