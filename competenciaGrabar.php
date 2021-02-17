<?php
	require_once 'connect.php';
	if(ISSET($_POST['save_admin'])){
		$descripcion = $_POST['descripcion'];
		$idTipo = $_POST['idTipo'];
		$definicion = htmlspecialchars($_POST['definicion']);
		$estado = $_POST['estado'];

		$q_admin = $conn->query("SELECT * FROM competencia WHERE descripcion = '$descripcion'") or die(mysqli_error($conn));
		$v_admin = $q_admin->num_rows;
		if($v_admin == 1){
			echo '
				<script type = "text/javascript">
					alert("Competencia ya existe en la BD");
					window.location = "competencia.php";
				</script>
			';
		}else{
			$conn->query("INSERT INTO competencia (descripcion,definicion,idTipo,estado) VALUES('$descripcion','$definicion', $idTipo,$estado)") or die(mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente!!");
					window.location = "competencia.php";
				</script>
			';
		}
	}
        
    
        
        
        