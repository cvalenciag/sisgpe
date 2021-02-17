<?php
	require_once 'connect.php';
	if(ISSET($_POST['edit_user'])){	
		$password = $_POST['password'];
		$apellido = $_POST['apellido'];
		$nombre = $_POST['nombre'];
		$idRol = $_POST['idRol'];
                $estado = $_POST['estado'];
                $idUsuario = $_REQUEST['admin_id'];
                
		
			$conn->query("UPDATE usuario SET password = '$password', apellido = '$apellido', nombre = '$nombre', idRol = '$idRol', estado='$estado' WHERE idUsuario = '$idUsuario' ") or die(mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente.");
					window.location = "usuario.php";
				</script>
			';
                        
		
	}
        
                elseif(ISSET($_POST['edit_perfil'])){	
                $password = $_POST['password'];
		$apellido = $_POST['apellido'];
		$nombre = $_POST['nombre'];
                $idUsuario = $_REQUEST['admin_id'];
                
                $conn->query("UPDATE usuario SET password = '$password', apellido = '$apellido', nombre = '$nombre' WHERE idUsuario = '$idUsuario' ") or die(mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente.");
					window.location = "home.php";
				</script>
			';

    }	