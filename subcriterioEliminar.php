<?php
	require_once 'connect.php';
	$conn->query("update subcriterio set estado='$_REQUEST[estado]' WHERE `idSubcriterio` = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	echo '
				<script type = "text/javascript">
					window.location = "subcriterio.php";
				</script>
			';