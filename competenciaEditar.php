<?php
	require_once 'connect.php';
	if(ISSET($_POST['edit_user'])){	
		$descripcion = $_POST['descripcion'];
		$idTipo = $_POST['idTipo'];
		$definicion = htmlspecialchars($_POST['definicion']);
		$estado = $_POST['estado'];
		
		
                $conn->query("UPDATE competencia SET definicion='$definicion',descripcion = '$descripcion', idTipo = '$idTipo',estado='$estado' WHERE idCompetencia = '$_REQUEST[idCompetencia]'") or die(mysqli_error($conn));
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente");
					window.location = "competencia.php";
				</script>
                ';
		
	}	