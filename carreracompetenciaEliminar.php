	<?php
	require_once 'connect.php';
	$conn->query("update carrera_competencia set eliminado='1' WHERE idCarreraCompetencia = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	if ($conn->affected_rows==1){ 
            $conn->query("update detalle_carrera_competencia set eliminado='1' WHERE idCarreraCompetencia = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	}
        echo '
				<script type = "text/javascript">
					window.location = "carreracompetencia.php";
				</script>
			';