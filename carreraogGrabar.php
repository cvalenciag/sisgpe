<?php
        require_once 'valid.php';
        $session_id= $_SESSION['session_id'];

	if(ISSET($_POST['save_user'])){
		$idCarrera = $_POST['idCarrera'];
		$fAprobacion = $_POST['fAprobacion'];
		$estado = $_POST['estado'];
		$sql=$conn->query("SELECT * from objgeneral, tmp where objgeneral.idObjgeneral=tmp.idObjgeneral and tmp.idSession='".$session_id."'");
		if ($sql->num_rows>0)
		{ // inicio num_rows
      $idCarreraOg = $conn->insert_id;

	    $sql2=$conn->query("SELECT * from carrera_og where fAprobacion = '" . $fAprobacion. "' and idCarrera='".$idCarrera."' and eliminado=0");


		if ($sql2->num_rows==0){

        $conn->query("INSERT INTO carrera_og (idCarreraOg,idCarrera,fAprobacion,estado,eliminado) VALUES('$idCarreraOg','$idCarrera','$fAprobacion','$estado','0')") or die (mysqli_error($conn));
		} else {
				 echo '
				<script type = "text/javascript">
					alert("Fecha de aprobacion para la carrera seleccionada ya se encuentra registrada en nuestro sistema");
					window.location = "carreraog.php";
				</script>
			';
		}
	if ($conn->affected_rows==1){

	$idCarreraOg = $conn->insert_id;

	while ($row=mysqli_fetch_array($sql))
	{
    $idTmp=$row['idTmp'];
	$idObjgeneral=$row['idObjgeneral'];
	$ordenamiento=$row['ordenamiento'];
	$conn->query("INSERT INTO detalle_carrera_og (idCarreraOg,idCarrera,idObjgeneral,ordenamiento,eliminado) VALUES('$idCarreraOg','$idCarrera','$idObjgeneral','$ordenamiento','0')") or die (mysqli_error($conn));
        if($conn->affected_rows==1)
            $delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$idTmp."' and idSession='".$session_id."'");

	}


          echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente.");
					window.location = "carreraog.php";
				</script>
			';

    } // cierra if affected_rows

	}else{
		 echo '
				<script type = "text/javascript">
					alert("Debe registrar el detalle de objetivos generales antes de grabar los objetivos generales or carrera.");
					window.location = "carreraog.php";
				</script>
			';
	} // cierra num_rows



	} // cierre if save_user
