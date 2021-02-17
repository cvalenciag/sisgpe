<?php
	 require_once 'valid.php';
     $session_id= $_SESSION['session_id'];
	if(ISSET($_POST['edit_user']))
        {
			$idMalla = $_REQUEST['idMalla'];
			$idCarrera = $_REQUEST['idCarrera'];
			$fAprobacion = $_POST['fAprobacion'];
			$idCurso 			= $_REQUEST['idCurso'];

			$conn->query("UPDATE malla SET fAprobacion = '$fAprobacion', fActualizacion = '$_POST[fActualizacion]',idCarrera = '$idCarrera' WHERE idMalla = '$idMalla'") or die(mysqli_error($conn));
			// $conn->query("UPDATE malla SET fAprobacion = '$fAprobacion', fActualizacion = '$_POST[fActualizacion]',idCarrera = '$idCarrera', estado = '$_POST[estado]' WHERE idMalla = '$idMalla'") or die(mysqli_error($conn));


			$sql=mysqli_query($conn, "SELECT * from detalle_malla where idCarrera='$idCarrera'");
				while ($row=mysqli_fetch_array($sql))
				{ // abre else

				$conn->query("UPDATE detalle_malla set idCarrera='$idCarrera' where idMalla='$idMalla' and idCarrera='$idCarrera' and idCurso='$idCurso'") or die (mysqli_error($conn));

				}  //cierra else
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente.");
					window.location = "malla.php";
				</script>
			';

	} // cierre if post edit user
