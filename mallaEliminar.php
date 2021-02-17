<?php
	require_once 'connect.php';
	$conn->query("update malla set eliminado='1' WHERE idMalla = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	if ($conn->affected_rows==1){ 
            $conn->query("update detalle_malla set eliminado='1' WHERE idMalla = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	}
        echo '
				<script type = "text/javascript">
					window.location = "malla.php";
				</script>
			';