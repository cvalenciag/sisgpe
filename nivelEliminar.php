<?php
	require_once 'connect.php';
	$conn->query("update nivel set estado='$_REQUEST[estado]' WHERE `idNivel` = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	echo '
				<script type = "text/javascript">
					window.location = "nivel.php";
				</script>
			';