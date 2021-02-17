<?php
	require_once 'connect.php';
	$conn->query("update og_oe set eliminado='1' WHERE idOgOe = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	if ($conn->affected_rows==1){ 
    $conn->query("update detalle_og_oe set eliminado='1' WHERE idOgOe = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	}
        echo '
				<script type = "text/javascript">
					window.location = "ogoe.php";
				</script>
			';