<?php
	require_once 'connect.php';
	if(ISSET($_POST['edit_user'])){
			$conn->query("UPDATE evaluador SET rucEvaluador = '$_POST[ruc]',nomEvaluador = '$_POST[nombres]',apeEvaluador = '$_POST[apellidos]',relUpEvaluador = '$_POST[tipoRelacion]',catEvaluador = '$_POST[categoriaEval]',idSector = '$_POST[idSector]',orgaEvaluador = '$_POST[organizacion]',idCargo = '$_POST[idCargo]',descEvaluador = '$_POST[descripcion]',celEvaluador = '$_POST[celular]',dirEvaluador = '$_POST[direccion]',correo1 = '$_POST[correo1]',correo2 = '$_POST[correo2]',nomAsistente = '$_POST[asistente]',correoAsistente = '$_POST[correo3]',sumillaEval = '$_POST[sumilla]',comentEvaluador = '$_POST[comentarios]',ultimaCapacitacion = '$_POST[fcapacitacion]', idusuario = '$_POST[usuario]', estado = '$_POST[estado]' WHERE idEvaluador = '$_REQUEST[idEvaluador]'") or die(mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente"); 
					window.location = "evaluador.php";
				</script>
			';

	}
