<?php
	require_once 'connect.php';
	if(ISSET($_POST['save_user'])){
		$dni = $_POST['dni'];
		$ruc = $_POST['ruc'];
		$nombres = htmlspecialchars($_POST['nombres']);
		$apellidos = htmlspecialchars($_POST['apellidos']);
		$tipoRelacion = $_POST['tipoRelacion'];
		$categoriaEval = $_POST['categoriaEval'];
		$idSector = $_POST['idSector'];
		$organizacion = htmlspecialchars($_POST['organizacion']);
		$idCargo = $_POST['idCargo'];
		$descripcion = htmlspecialchars($_POST['descripcion']);
		$celular = $_POST['celular'];
		$direccion = htmlspecialchars($_POST['direccion']);
		$correo1 = $_POST['correo1'];
		$correo2 = $_POST['correo2'];
		$asistente = htmlspecialchars($_POST['asistente']);
		$correo3 = $_POST['correo3'];
		$sumilla = htmlspecialchars($_POST['sumilla']);
		$comentarios = htmlspecialchars($_POST['comentarios']);
		$fcapacitacion = $_POST['fcapacitacion'];
		$usuario = $_POST['usuario'];
		$estado = $_POST['estado']; 

		$q_admin = $conn->query("SELECT * FROM evaluador WHERE dniEvaluador = '$_POST[dni]'") or die (mysqli_error($conn));
		$v_admin = $q_admin->num_rows;
		if($v_admin == 1){
			echo '
				<script type = "text/javascript">
					alert("Evaluador ya existe");
					window.location = "evaluador.php";
				</script>
			';
		}else{
			$conn->query("INSERT INTO evaluador (dniEvaluador,rucEvaluador,nomEvaluador,apeEvaluador,relUpEvaluador,catEvaluador,idSector,orgaEvaluador,idCargo,descEvaluador,celEvaluador,dirEvaluador,correo1,correo2,nomAsistente,correoAsistente,sumillaEval,comentEvaluador,ultimaCapacitacion,idusuario,estado) VALUES('$dni','$ruc', '$nombres','$apellidos',$tipoRelacion,$categoriaEval,'$idSector','$organizacion','$idCargo','$descripcion','$celular','$direccion','$correo1','$correo2','$asistente','$correo3','$sumilla','$comentarios','$fcapacitacion','$usuario',$estado)") or die (mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente!!");
					window.location = "evaluador.php";
				</script>
			';
		}
	}
