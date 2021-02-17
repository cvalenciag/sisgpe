<?php
	require_once 'connect.php';
	if(ISSET($_POST['save_user'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$email = $_POST['email'];
		$idRol = $_POST['idRol'];
		$estado = $_POST['estado'];

		$q_admin = $conn->query("SELECT * FROM `usuario` WHERE `username` = '$username'") or die (mysqli_error($conn));
		$v_admin = $q_admin->num_rows;

		$q_admin1 = $conn->query("SELECT * FROM `usuario` WHERE `email` = '$email'") or die (mysqli_error($conn));
		$v_admin1 = $q_admin1->num_rows;
		if($v_admin == 1){
			echo '
				<script type = "text/javascript">
					alert("El nombre de usuario ya existe.");
					window.location = "usuario.php";
				</script>
			';
		}elseif ($v_admin1 == 1)
		{
			echo '
				<script type = "text/javascript">
					alert("El email ya existe.");
					window.location = "usuario.php";
				</script>
			';
		}else{
			$conn->query("INSERT INTO `usuario` (username,password,nombre,apellido,email,idRol,estado) VALUES('$username', '$password', '$nombre', '$apellido', '$email', $idRol,'$estado')") or die (mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente.");
					window.location = "usuario.php";
				</script>
			';
		}
	}
