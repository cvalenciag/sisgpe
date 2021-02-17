<?php
	require_once 'connect.php';
	if(ISSET($_POST['save_user'])){
		$idCriterio = $_POST['idCriterio'];
		$descripcion = htmlspecialchars($_POST['descripcion']);
		$estado = $_POST['estado'];

		$q_admin = $conn->query("SELECT * FROM subcriterio WHERE descripcion = '$_POST[descripcion]'") or die (mysqli_error($conn));
		$v_admin = $q_admin->num_rows;
		if($v_admin == 1){
			echo '
				<script type = "text/javascript">
					alert("La descripción del nivel ya existe.");
					window.location = "subcriterio.php";
				</script>
			'; 
		}else{
			$conn->query("INSERT INTO subcriterio (idCriterio,descripcion,estado) VALUES($idCriterio,'$descripcion',$estado)") or die (mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente.");
					window.location = "subcriterio.php";
				</script>
			';
		}
	}
