<?php
        require_once 'valid.php';
        $session_id= $_SESSION['session_id'];

	// if(ISSET($_POST['save_user'])){
		$idObjgeneral = $_POST['idObjgeneral'];
		$fAprobacion = $_POST['fAprobacion'];
		$estado = $_POST['estado'];
		$idCompetencia = $_POST['competencia'];



  $sql=$conn->query("SELECT * FROM objespecifico o, tmp t WHERE o.idObjespecifico=t.idObjespecifico AND t.idObjgeneral='".$idObjgeneral."' AND t.idSession='".$session_id."'");

	if ($sql->num_rows>0)
	{ // inicio num_rows
    $idOgOe = $conn->insert_id;

    $sql2=$conn->query("SELECT * FROM og_oe WHERE fAprobacion='".$fAprobacion."' AND idObjgeneral='".$idObjgeneral."' AND eliminado=0");

    if ($sql2->num_rows==0)
    {
      $conn->query("INSERT INTO og_oe (idOgOE,idCompetencia,idObjgeneral,estado,fAprobacion,eliminado)
                    VALUES('$idOgOe','$idCompetencia','$idObjgeneral','$estado','$fAprobacion','0')") or die (mysqli_error($conn));
    }
      // else {
			// 	 echo '
			// 	<script type = "text/javascript">
			// 		alert("Fecha de aprobacion para el objetivo general seleccionado ya se encuentra registrada en nuestro sistema");
			// 		window.location = "ogoe.php";
			// 	</script>
			// ';
			// }


	  if ($conn->affected_rows==1)
    {

	     $idOgOe = $conn->insert_id;

       /* $sql=mysqli_query($conn, "select * from objespecifico, tmp where objespecifico.idObjespecifico=tmp.idObjespecifico and tmp.idSession='".$session_id."'");*/
	      while ($row=mysqli_fetch_array($sql))
	      {
          $idTmp=$row['idTmp'];
	        $idObjespecifico=$row['idObjespecifico'];
	        $ordenamiento=$row['ordenamiento'];

          $conn->query("INSERT INTO detalle_og_oe (idOgOe,idObjgeneral,idObjespecifico,ordenamiento,eliminado) VALUES('$idOgOe','$idObjgeneral','$idObjespecifico','$ordenamiento','0')") or die (mysqli_error($conn));

          if($conn->affected_rows==1){
            $delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$idTmp."' and idSession='".$session_id."'");
          }
	      }


        echo '<script type = "text/javascript">
                alert("Registro guardado correctamente.");
                window.location = "ogoe.php";
              </script>';

    }

  }else{
		 // echo '
			// 	<script type = "text/javascript">
			// 		alert("Debe registrar el detalle de objetivos específicos antes de grabar los objetivos de aprendizaje.");
			// 		window.location = "ogoe.php";
			// 	</script>
			// ';
      echo "<input type='hidden' id='idResult' value='2'/>";
	} // cierra num_rows



	// } // cierre if save_user
