<?php
	 require_once 'valid.php';
     $session_id= $_SESSION['session_id'];
	if(ISSET($_POST['edit_user'])){
			$idCarreraCompetencia = $_REQUEST['idCarreraCompetencia'];
			$idCarrera = $_REQUEST['idCarrera'];
			$fAprobacion = $_POST['fAprobacion'];


			$conn->query("UPDATE carrera_competencia SET fAprobacion = '$fAprobacion',idCarrera = '$idCarrera' WHERE idCarreraCompetencia = '$idCarreraCompetencia'") or die(mysqli_error($conn));

                        $sql=mysqli_query($conn, "select * from detalle_carrera_competencia where idCarrera='$idCarrera'");

				while ($row=mysqli_fetch_array($sql))
				{ // abre else

				$conn->query("update detalle_carrera_competencia set idCarrera='$idCarrera' where idCarreraCompetencia='$idCarreraCompetencia' and idCarrera='$idCarrera' and idCompetencia='$idCompetencia'") or die (mysqli_error($conn));


				}  //cierra else
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente.");
					window.location = "carreracompetencia.php";
				</script>
			';

	} // cierre if post edit user
