<?php
	require_once 'connect.php';
	if(ISSET($_POST['save_user'])){
		$nombreCorto = $_POST['nombreCorto'];
		$descripcion = htmlspecialchars($_POST['descripcion']);
		$idFacultad = $_POST['idFacultad'];
		$estado = $_POST['estado'];
		
		$q_admin = $conn->query("SELECT * FROM carrera WHERE nombreCorto = '$_POST[nombreCorto]'") or die (mysqli_error($conn));
		$v_admin = $q_admin->num_rows;
		if($v_admin == 1){
			echo '
				<script type = "text/javascript">
					alert("Nombre corto ya existe");
					window.location = "carrera.php";
				</script>
			';
		}else{
			$conn->query("INSERT INTO carrera (nombreCorto,descripcion,idFacultad,estado) VALUES('$nombreCorto','$descripcion', $idFacultad,$estado)") or die (mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente!!");
					window.location = "carrera.php";
				</script>
			';
		}
	}
        
    
        
        
        