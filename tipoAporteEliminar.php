<?php
	require_once 'connect.php';
	$conn->query("UPDATE perfilegresado SET eliminado='1' WHERE idPerfilEgresado = '$_REQUEST[idPerfilEgresado]'") or die(mysqli_error($conn));

  if ($conn->affected_rows==1){
            $conn->query("UPDATE detalle_perfilegresado_curso SET eliminado='1' WHERE idPerfilEgresado = '$_REQUEST[idPerfilEgresado]'") or die(mysqli_error($conn));
	}


	echo '
	<script type = "text/javascript">
		window.location = "tipoAporte.php";
	</script>
';
 
