<?php
	require_once 'connect.php';
	if(ISSET($_POST['save_user'])){
		
		$q_admin = $conn->query("SELECT * FROM `objespecifico` WHERE `definicion` = '$_POST[definicion]'") or die (mysqli_error($conn));
		$v_admin = $q_admin->num_rows;
		if($v_admin == 1){
			echo '
				<script type = "text/javascript">
					alert("Definición ya existe");
					window.location = "objespecifico.php";
				</script>
			';
		}else{
			$conn->query("INSERT INTO objespecifico (definicion,estado) VALUES ('$_POST[definicion]','$_POST[estado]')") or die (mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente!!");
					window.location = "objespecifico.php";
				</script>
			';
		}
	}
        
        
        