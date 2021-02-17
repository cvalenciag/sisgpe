<?php
	require_once 'connect.php';
	if(ISSET($_POST['save_user'])){
		
		$q_admin = $conn->query("SELECT * FROM `curso` WHERE `codUpCurso` = '$_POST[codUpCurso]'") or die (mysqli_error($conn));
		$v_admin = $q_admin->num_rows;
		if($v_admin == 1){
			echo '
				<script type = "text/javascript">
					alert("Codigo de curso ya existe");
					window.location = "curso.php";
				</script>
			';
		}else{
			$conn->query("INSERT INTO curso (nombreCurso,codUpCurso,tipoCurso,idDepartamento,cantHorasPractica,cantHorasTeorica,credito,estado) VALUES ('$_POST[nombreCurso]','$_POST[codUpCurso]',
                        '$_POST[tipoCurso]','$_POST[idDepartamento]','$_POST[cantHorasPractica]','$_POST[cantHorasTeorica]','$_POST[credito]','$_POST[estado]')") or die (mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente!!");
					window.location = "curso.php";
				</script>
			';
		}
	}
        
        
        