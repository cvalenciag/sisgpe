<?php
	require_once 'connect.php';
	//$conn->query("DELETE FROM `facultad` WHERE `idFacultad` = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$conn->query("UPDATE facultad SET estado='$_REQUEST[estado]' WHERE idFacultad = '$_REQUEST[admin_id]'") or die (mysqli_error($conn));
	echo '
				<script type = "text/javascript">
					window.location = "facultad.php";
				</script>
			';