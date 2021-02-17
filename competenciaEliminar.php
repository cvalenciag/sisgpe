<?php
	require_once 'connect.php';
	$conn->query("update competencia set estado='$_REQUEST[estado]' WHERE `idCompetencia` = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	echo '
				<script type = "text/javascript">
					window.location = "competencia.php";
				</script>
			';