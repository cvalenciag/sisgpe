<?php
	 require_once 'valid.php';
     $session_id= $_SESSION['session_id'];
	if(ISSET($_POST['edit_user'])){
			$idCarreraOg = $_REQUEST['idCarreraOg'];
			$idCarrera = $_REQUEST['idCarrera'];
			$fAprobacion = $_POST['fAprobacion'];
			$idObjgeneral = $_REQUEST['idObjgeneral'];

			$conn->query("UPDATE carrera_og SET fAprobacion = '$fAprobacion',idCarrera = '$idCarrera'  WHERE idCarreraOg = '$idCarreraOg'") or die(mysqli_error($conn));

			$sql=mysqli_query($conn, "select * from detalle_carrera_og where idCarrera='$idCarrera'");
				while ($row=mysqli_fetch_array($sql))
				{ // abre else

				$conn->query("update detalle_carrera_og set idCarrera='$idCarrera' where idCarreraOg='$idCarreraOg' and idCarrera='$idCarrera' and idObjgeneral='$idObjgeneral'") or die (mysqli_error($conn));
				// $conn->query("update detalle_carrera_og set idCarrera='$idCarrera' where idCarreraOg='$idCarreraOg' and idCarrera='$idCarrera'") or die (mysqli_error($conn));

				}  //cierra else
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente.");
					window.location = "carreraog.php";
				</script>
			';

	} // cierre if post edit user
