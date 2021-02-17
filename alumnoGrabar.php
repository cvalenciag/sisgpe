<?php
	require_once 'connect.php';
	if(ISSET($_POST['save_user']))
	{
	// 	echo 'entra';

		$codSii 		= $_POST['codigosii'];
		$nombre 		= htmlspecialchars($_POST['nombre']);
		$apellido 	= htmlspecialchars($_POST['apellido']);
    $codPc 			= $_POST['codigopc'];
		$idCarrera	= $_POST['idCarrera'];
		$estado 		= $_POST['estado'];

		// echo 'SII_'.$codSii.'_PC_'.$codPc;

		$q_admin = $conn->query("SELECT * FROM alumno WHERE codSII='$codSii'") or die (mysqli_error($conn));
		$v_admin = $q_admin->num_rows;

		$q_admin1 = $conn->query("SELECT * FROM alumno WHERE codPowerCampus='$codPc'") or die (mysqli_error($conn));
		$v_admin1 = $q_admin1->num_rows;

		if($v_admin > 0){
			echo '
				<script type = "text/javascript">
					alert("Codigo SII ya existe.");
					window.location = "alumno.php";
				</script>
			';
		}else if ($v_admin1 > 0) {
			echo '
				<script type = "text/javascript">
					alert("Codigo Power Campus ya existe.");
					window.location = "alumno.php";
				</script>
			';
		}else{
			$conn->query("INSERT INTO alumno (codSII,nomAlumno, apeAlumno,codPowerCampus,idCarrera,estado) VALUES('$codSii','$nombre','$apellido','$codPc', $idCarrera, $estado)") or die (mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente.");
					window.location = "alumno.php";
				</script>
			';
		}
	}
