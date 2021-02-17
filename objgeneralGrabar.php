<?php
	require_once 'connect.php';
	if(ISSET($_POST['save_user'])){
		
		$q_admin = $conn->query("SELECT * FROM `objgeneral` WHERE `codObjGeneral` = '$_POST[codObjGeneral]'") or die (mysqli_error($conn));
		$v_admin = $q_admin->num_rows;
		if($v_admin == 1){
			echo '
				<script type = "text/javascript">
					alert("Codigo objetivo general ya existe");
					window.location = "objgeneral.php";
				</script>
			';
		}else{
			$conn->query("INSERT INTO objgeneral (codObjGeneral,definicion,idCompetencia,estado) VALUES ('$_POST[codObjGeneral]','$_POST[definicion]','$_POST[idCompetencia]','$_POST[estado]')") or die (mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente!!");
					window.location = "objgeneral.php";
				</script>
			';
		}
	}
        
        
        