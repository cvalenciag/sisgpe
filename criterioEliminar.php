<?php
	require_once 'connect.php';
	//$conn->query("DELETE FROM `facultad` WHERE `idFacultad` = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$conn->query("UPDATE criterio SET estado='$_REQUEST[estado]' WHERE idCriterio = '$_REQUEST[admin_id]'") or die (mysqli_error($conn));
	echo '
				<script type = "text/javascript">
					window.location = "criterio.php";
				</script>
			';