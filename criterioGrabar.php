<?php
	require_once 'connect.php';
	if(ISSET($_POST['save_user'])){

		$q_admin = $conn->query("SELECT * FROM `criterio` WHERE `descripcion` = '$_POST[descripcion]'") or die (mysqli_error($conn));
		$v_admin = $q_admin->num_rows;
		if($v_admin == 1){
			echo '
				<script type = "text/javascript">
					alert("El criterio ya existe.");
					window.location = "criterio2.php";
				</script>
			'; 
		}else{
			$conn->query("INSERT INTO criterio (descripcion,definicion,estado) VALUES ('$_POST[descripcion]','$_POST[definicion]','$_POST[estado]')") or die (mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente.");
					window.location = "criterio2.php";
				</script>
			';
		}
	}
