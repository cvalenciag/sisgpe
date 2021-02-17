<?php
	require_once 'connect.php';
	if(ISSET($_POST['save_user'])){
		
		$q_admin = $conn->query("SELECT * FROM `departamento` WHERE `nombreCorto` = '$_POST[nombreCorto]'") or die (mysqli_error($conn));
		$v_admin = $q_admin->num_rows;
		if($v_admin == 1){
			echo '
				<script type = "text/javascript">
					alert("Codigo de Departamento ya existe");
					window.location = "departamento.php";
				</script>
			';
		}else{
			$conn->query("INSERT INTO departamento (nombreCorto,codUpDepartamento,descripcion,estado) VALUES ('$_POST[nombreCorto]','$_POST[codUpDepartamento]','$_POST[descripcion]','$_POST[estado]')") or die (mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente!!");
					window.location = "departamento.php";
				</script>
			';
		}
	}
        
        
        