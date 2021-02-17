<?php
	require_once 'connect.php';
	if(ISSET($_POST['save_user'])){
		$descripcion = $_POST['descripcion'];

		$q_admin = $conn->query("SELECT * FROM `nivel` WHERE `descripcion` = '$descripcion'") or die(mysqli_error($conn));
		$v_admin = $q_admin->num_rows;
		if($v_admin == 1){
			echo '
				<script type = "text/javascript">
					alert("El nivel ya existe.");
					window.location = "nivel.php";
				</script>
			';
		}else{
			$conn->query("INSERT INTO `nivel` (descripcion,estado) VALUES('$descripcion','$_POST[estado]')") or die(mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente.");
					window.location = "nivel.php";
				</script>
			';
		}
	}
