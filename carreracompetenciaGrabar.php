<?php
        require_once 'valid.php';
        $session_id= $_SESSION['session_id'];
		
		
	if(ISSET($_POST['save_user'])){
		$idCarrera = $_POST['idCarrera'];
		$fAprobacion = $_POST['fAprobacion'];
		$estado = $_POST['estado'];


$sql=$conn->query("select * from competencia, tmp where competencia.idCompetencia=tmp.idCompetencia and tmp.idCarrera='".$idCarrera."' and tmp.idSession='".$session_id."'");

	if ($sql->num_rows>0)
	{ // inicio num_rows

	    $sql2=$conn->query("select * from carrera_competencia where fAprobacion = '" . $fAprobacion. "' and idCarrera='".$idCarrera."' and eliminado=0");
		if ($sql2->num_rows==0){

        $conn->query("INSERT INTO carrera_competencia (idCarrera,fAprobacion,estado) VALUES('$idCarrera','$fAprobacion','$estado')") or die (mysqli_error($conn));

	} else {
				 echo '
				<script type = "text/javascript">
					alert("Fecha de aprobacion para la carrera seleccionada ya se encuentra registrada en nuestro sistema");
					window.location = "carreracompetencia.php";
				</script>
			';
			}


	if ($conn->affected_rows==1){

	$idCarreraCompetencia = $conn->insert_id;

        /*$sql=mysqli_query($conn, "select * from competencia, tmp where competencia.idCompetencia=tmp.idCompetencia and tmp.idSession='".$session_id."'");*/
	while ($row=mysqli_fetch_array($sql))
	{
    $idCarreraCompetencia = $conn->insert_id;

    $idTmp=$row['idTmp'];
	  $idCompetencia=$row['idCompetencia'];
	  $ordenamiento=$row['ordenamiento'];

    $conn->query("INSERT INTO detalle_carrera_competencia (idCarreraCompetencia,idCarrera,idCompetencia,ordenamiento) VALUES('$idCarreraCompetencia','$idCarrera','$idCompetencia','$ordenamiento')") or die (mysqli_error($conn));
        if($conn->affected_rows==1)
            $delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$idTmp."' and idSession='".$session_id."'");

	}


          echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente.");
					window.location = "carreracompetencia.php";
				</script>
			';

            }
	}else{
		 echo '
				<script type = "text/javascript">
					alert("Debe registrar el detalle de competencias antes de grabar las competencias or carrera.");
					window.location = "carreracompetencia.php";
				</script>
			';
	} // cierra num_rows



	} // cierre if save_user
?>