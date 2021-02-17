<?php
require_once 'valid.php';
$session_id= $_SESSION['session_id'];

	// if(ISSET($_POST['save_user'])){
$idCarrera    = $_POST['idCarrera'];
$fAprobacion  = $_POST['fAprobacion'];
$estado       = $_POST['estado'];


$sql=$conn->query("SELECT * FROM competencia c, tmp t WHERE c.idCompetencia=t.idCompetencia AND t.idCarrera='".$idCarrera."'
                   AND t.idSession='".$session_id."'");
// $sql=$conn->query("SELECT * FROM competencia c, tmp t WHERE c.idCompetencia=t.idCompetencia AND t.idCarrera='".$idCarrera."'");

if ($sql->num_rows>0)
{ // inicio num_rows

  $idCarreraCompetencia = $conn->insert_id;

	 $sql2=$conn->query("SELECT * FROM carrera_competencia WHERE fAprobacion='".$fAprobacion."' AND idCarrera='".$idCarrera."'
                       AND eliminado=0");

    if ($sql2->num_rows==0)
    {
      $conn->query("INSERT INTO carrera_competencia (idCarreraCompetencia,idCarrera,estado,fAprobacion,eliminado)
                    VALUES('$idCarreraCompetencia','$idCarrera','$estado','$fAprobacion','0')") or die (mysqli_error($conn));
    }
  // else {
	// 			 echo '
	// 			<script type = "text/javascript">
	// 				alert("Fecha de aprobacion para la carrera seleccionada ya se encuentra registrada en nuestro sistema");
	// 				window.location = "carreracompetencia.php";
	// 			</script>
	// 		';
	// 		}


	if ($conn->affected_rows==1)
  {

    $idCarreraCompetencia = $conn->insert_id;

    while ($row=mysqli_fetch_array($sql))
	  {

      $idTmp         =  $row['idTmp'];
	    $idCompetencia = $row['idCompetencia'];
	    $ordenamiento  = $row['ordenamiento'];

      $conn->query("INSERT INTO detalle_carrera_competencia (idCarreraCompetencia,idCarrera,idCompetencia,ordenamiento,eliminado)
                    VALUES('$idCarreraCompetencia','$idCarrera','$idCompetencia','$ordenamiento','0')") or die (mysqli_error($conn));

        if($conn->affected_rows==1){
          $delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$idTmp."' and idSession='".$session_id."'");
          // $delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$idTmp."'");
        }
    }//WHILE

    echo '<script type = "text/javascript">
					alert("Registro agregado correctamente.");
					window.location = "carreracompetencia.php";
          </script>';

  }

}else{
      echo "<input type='hidden' id='idResultC' value='2'/>";
		 // echo '
			// 	<script type = "text/javascript">
			// 		alert("Debe registrar el detalle de competencias antes de grabar las competencias or carrera.");
			// 		window.location = "carreracompetencia.php";
			// 	</script>
			// ';
} // cierra num_rows
?>