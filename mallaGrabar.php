<?php
        require_once 'valid.php';
        $session_id= $_SESSION['session_id'];

	if(ISSET($_POST['save_user']))
	{ // inicio save_user
		$idCarrera      = $_POST['idCarrera'];
		$fAprobacion    = $_POST['fAprobacion'];
		$fActualizacion = $_POST['fActualizacion'];
		$estado         = $_POST['estado'];



    $sql=$conn->query("SELECT * from curso, tmp where curso.idCurso=tmp.idCurso and tmp.idCarrera='".$idCarrera."' and tmp.idSession='".$session_id."'");

	if ($sql->num_rows>0)
	{ // inicio num_rows

	    $sql2=$conn->query("select * from malla where fAprobacion = '" . $fAprobacion. "' and idCarrera='".$idCarrera."' and fActualizacion='".$fActualizacion."' and eliminado=0");
		if ($sql2->num_rows==0){
			$conn->query("INSERT INTO malla (idCarrera,fAprobacion,fActualizacion,estado) VALUES('$idCarrera','$fAprobacion', '$fActualizacion','$estado')") or die (mysqli_error($conn));
			} else {
				 echo '
				<script type = "text/javascript">
					alert("La carrera seleccionada ya se encuentra registrada en nuestro sistema. Cambie la fecha de actualizacion");
					window.location = "malla.php";
				</script>
			';
			}

	if ($conn->affected_rows==1)
	{ // inicio affected_rows

	$idMalla = $conn->insert_id;

	while ($row=mysqli_fetch_array($sql))
	{ // abre while
        $idTmp=$row['idTmp'];
	$idCurso=$row['idCurso'];
	$ciclo=$row['ciclo'];
	$obligatorio=$row['obligatorio'];
	$aol=$row['aol'];
	$conn->query("INSERT INTO detalle_malla (idMalla,idCarrera,idCurso,ciclo,obligatoriedad,aol) VALUES('$idMalla','$idCarrera','$idCurso', '$ciclo','$obligatorio','$aol')") or die (mysqli_error($conn));
        if($conn->affected_rows==1)
            $delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$idTmp."' and idSession='".$session_id."'");

	} // cierra while


          echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente.");
					window.location = "malla.php";
				</script>
			';

	} // cierra if affected_rows

	}else{
		 echo '
				<script type = "text/javascript">
					alert("Debe registrar el detalle de cursos antes de grabar la malla.");
					window.location = "malla.php";
				</script>
			';
	} // cierra num_rows



	} // cierre if save_user
